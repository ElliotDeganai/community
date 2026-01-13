<template>
  <div class="rte h-full">
    <div class="rte-toolbar" role="toolbar" aria-label="Formatting toolbar">
      <button type="button" @click="exec('bold')" :disabled="readonly" title="Bold">B</button>
      <button type="button" @click="exec('italic')" :disabled="readonly" title="Italic">I</button>
      <button type="button" @click="exec('underline')" :disabled="readonly" title="Underline">U</button>
      <button type="button" @click="exec('formatBlock', '<h1>')" :disabled="readonly" title="H1">H1</button>
      <button type="button" @click="exec('insertUnorderedList')" :disabled="readonly" title="Bullet list">• List</button>
      <button type="button" @click="exec('insertOrderedList')" :disabled="readonly" title="Numbered list">1. List</button>
      <button type="button" @click="insertLink()" :disabled="readonly" title="Insert link">Link</button>
      <button type="button" @click="insertImage()" :disabled="readonly" title="Insert image">Image</button>
      <button type="button" @click="undo()" :disabled="readonly" title="Undo">↺</button>
      <button type="button" @click="redo()" :disabled="readonly" title="Redo">↻</button>
      <button type="button" @click="toggleHtmlView" title="Toggle HTML view">HTML</button>
    </div>

<div v-if="!showHtml" class="rte-editor" ref="editor" contenteditable="true"
         :class="{disabled: disabled || readonly}"
         :placeholder="placeholder"
         @input="syncFromEditor"
         @keydown="onKeydown"
         @paste="onPaste"
         aria-multiline="true"
         role="textbox"
         :aria-readonly="readonly.toString()">
    </div>

    <textarea v-else class="rte-html list-disc" v-model="internalHtml"></textarea>

    <div class="rte-footer">
      <small>{{ charCount }} / {{ maxLength ?? '∞' }}</small>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted, defineProps, defineEmits, computed, nextTick } from 'vue'

const props = defineProps({
  modelValue: { type: String, default: '' },
  placeholder: { type: String, default: 'Commencez à écrire...' },
  readonly: { type: Boolean, default: false },
  disabled: { type: Boolean, default: false },
  maxLength: { type: Number, default: null },
  sanitize: { type: Boolean, default: true } // basic sanitization
})

const emit = defineEmits(['update:modelValue'])

const editor = ref(null)
const internalHtml = ref(props.modelValue)
const showHtml = ref(false)

const charCount = computed(() => {
  return (editor.value?.innerText ?? '').length
})

// Synchronisation parent → éditeur (très important : nextTick + comparaison stricte)
watch(() => props.modelValue, (newVal) => {
  if (newVal !== internalHtml.value) {
    internalHtml.value = newVal
    if (editor.value && !showHtml.value) {
      nextTick(() => {
        // On écrit seulement si nécessaire pour éviter les boucles infinies
        if (editor.value.innerHTML !== newVal) {
          editor.value.innerHTML = newVal || ''
        }
      })
    }
  }
})

watch(internalHtml, (val) => {
  emit('update:modelValue', val)
})

// Initialisation au montage (avec nextTick pour être sûr que le div est dans le DOM)
onMounted(() => {
  nextTick(() => {
    if (editor.value) {
      editor.value.innerHTML = props.modelValue || ''
    }
  })
})

function exec(command, value = null) {
  if (props.readonly || props.disabled) return
  document.execCommand(command, false, value)
  syncFromEditor()
}

function insertLink() {
  if (props.readonly || props.disabled) return
  const url = prompt('URL du lien')
  if (url) exec('createLink', url)
}

function insertImage() {
  if (props.readonly || props.disabled) return
  const url = prompt('URL de l\'image')
  if (url) exec('insertImage', url)
}

function undo() { exec('undo') }
function redo() { exec('redo') }

function toggleHtmlView() {
  showHtml.value = !showHtml.value
  if (showHtml.value) {
    internalHtml.value = editor.value?.innerHTML ?? ''
  } else {
    // set editor from textarea
    const html = internalHtml.value
    if (editor.value) editor.value.innerHTML = props.sanitize ? sanitizeHtml(html) : html
  }
}

function onInput() {
  syncFromEditor()
}

// Synchronisation éditeur → parent
const syncFromEditor = () => {
  if (!editor.value) return
  const html = editor.value.innerHTML
  internalHtml.value = props.sanitize ? sanitizeHtml(html) : html
  emit('update:modelValue', internalHtml.value)
}

function onKeydown(e) {
  // keyboard shortcuts: Ctrl/Cmd + B/I/U
  if ((e.ctrlKey || e.metaKey) && !e.shiftKey) {
    if (e.key.toLowerCase() === 'b') { e.preventDefault(); exec('bold') }
    if (e.key.toLowerCase() === 'i') { e.preventDefault(); exec('italic') }
    if (e.key.toLowerCase() === 'u') { e.preventDefault(); exec('underline') }
  }
}

function onPaste(e) {
  // simple paste handling: paste plain text to avoid arbitrary markup
  if (!e.clipboardData) return
  e.preventDefault()
  const text = e.clipboardData.getData('text/plain')
  // insert text at cursor
  document.execCommand('insertText', false, text)
  syncFromEditor()
}

// Very small sanitizer: allow a safe subset of tags + basic attributes
function sanitizeHtml(dirty) {
  if (!dirty) return ''
  const doc = new DOMParser().parseFromString(dirty, 'text/html')
  const whitelist = {
    'A': ['href', 'title', 'target', 'rel'],
    'B': [], 'STRONG': [], 'I': [], 'EM': [], 'U': [],
    'P': [], 'BR': [], 'DIV': [], 'SPAN': ['style'],
    'UL': [], 'OL': [], 'LI': [],
    'H1': [], 'H2': [], 'H3': [], 'H4': [],
    'IMG': ['src', 'alt', 'width', 'height']
  }

  function clean(node) {
    const nodeName = node.nodeName
    if (node.nodeType === 3) return node // text node ok
    if (!whitelist[nodeName]) {
      // unwrap: move children up
      const parent = node.parentNode
      while (node.firstChild) parent.insertBefore(node.firstChild, node)
      parent.removeChild(node)
      return
    }
    // remove unwanted attributes
    const allowed = whitelist[nodeName]
    // clone attributes because NamedNodeMap is live
    const attrs = Array.from(node.attributes || [])
    for (const attr of attrs) {
      if (!allowed.includes(attr.name)) node.removeAttribute(attr.name)
      else {
        // simple href/src validation
        if ((attr.name === 'href' || attr.name === 'src') && attr.value.startsWith('javascript:')) node.removeAttribute(attr.name)
      }
    }
    // recurse
    for (const child of Array.from(node.childNodes)) clean(child)
  }

  for (const child of Array.from(doc.body.childNodes)) clean(child)
  return doc.body.innerHTML
}

</script>

<style scoped>
.rte { border: 1px solid #e5e7eb; border-radius: 8px; font-family: system-ui, sans-serif; }
.rte-toolbar { padding: 8px; display:flex; gap:6px; flex-wrap:wrap; background:#fafafa; border-bottom:1px solid #eee }
.rte-toolbar button { padding:6px 8px; border-radius:6px; border:1px solid #ddd; background:white; cursor:pointer }
.rte-editor { min-height:140px; padding:12px; outline:none; white-space:pre-wrap }
.rte-editor[contenteditable="true"]:empty:before { content: attr(placeholder); color:#9ca3af }
.rte-html { width:100%; min-height:140px; padding:8px; font-family:monospace }
.rte-footer { padding:6px 8px; text-align:right; color:#6b7280 }
.disabled { background:#f3f4f6; pointer-events:none; opacity:0.7 }
</style>
