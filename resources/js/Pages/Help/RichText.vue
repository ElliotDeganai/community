<template>
    <div class="border-black border h-full">
        <div class="flex flex-wrap justify-between px-3 py-2" v-if="editor">
            <button class="rich-text-style-button" @click.prevent="editor.chain().focus().toggleBold().run()" :class="{ 'is-active': editor.isActive('bold') }">
                bold
            </button>
            <button class="rich-text-style-button" @click.prevent="editor.chain().focus().toggleItalic().run()" :class="{ 'is-active': editor.isActive('italic') }">
                italic
            </button>
            <button class="rich-text-style-button" @click.prevent="editor.chain().focus().toggleStrike().run()" :class="{ 'is-active': editor.isActive('strike') }">
                strike
            </button>
            <button class="rich-text-style-button" @click.prevent="editor.chain().focus().toggleUnderline().run()" :class="{ 'is-active': editor.isActive('underline') }">
                underline
            </button>
<!--             <button class="rich-text-style-button" @click.prevent="editor.chain().focus().setColor('#DC2626').run()" :class="{ 'is-active': editor.isActive('textStyle', { color: '#DC2626' })}">
                <span class="text-red-600">red</span>
            </button>
            <button class="rich-text-style-button" @click.prevent="editor.chain().focus().setColor('#16a34a').run()" :class="{ 'is-active': editor.isActive('textStyle', { color: '#16a34a' })}">
                <span class="text-green-600">green</span>
            </button>
            <button class="rich-text-style-button" @click.prevent="editor.chain().focus().setColor('#F97316').run()" :class="{ 'is-active': editor.isActive('textStyle', { color: '#F97316' })}">
               <span class="text-orange-500">orange</span>
            </button>
            <button class="rich-text-style-button" @click.prevent="editor.chain().focus().setColor('#EAB308').run()" :class="{ 'is-active': editor.isActive('textStyle', { color: '#EAB308' })}">
               <span class="text-yellow-500">Yellow</span>
            </button>
            <button class="rich-text-style-button" @click.prevent="editor.chain().focus().setColor('#2563EB').run()" :class="{ 'is-active': editor.isActive('textStyle', { color: '#2563EB' })}">
               <span class="text-blue-600">blue</span>
            </button> -->
            <button class="rich-text-style-button" @click.prevent="editor.chain().focus().toggleHeading({ level: 1 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 1 }) }">
                h1
            </button>
            <button class="rich-text-style-button" @click.prevent="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }">
                h2
            </button>
            <button class="rich-text-style-button" @click.prevent="editor.chain().focus().toggleHeading({ level: 3 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 3 }) }">
                h3
            </button>
            <button class="rich-text-style-button" @click.prevent="editor.chain().focus().toggleHeading({ level: 4 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 4 }) }">
                h4
            </button>
            <button class="rich-text-style-button" @click.prevent="editor.chain().focus().toggleHeading({ level: 5 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 5 }) }">
                h5
            </button>
            <button class="rich-text-style-button" @click.prevent="editor.chain().focus().toggleHeading({ level: 6 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 6 }) }">
                h6
            </button>
            <button class="rich-text-style-button" @click.prevent="editor.chain().focus().toggleBulletList().run()" :class="{ 'is-active': editor.isActive('bulletList') }">
                bullet list
            </button>
            <button class="rich-text-style-button" @click.prevent="editor.chain().focus().toggleOrderedList().run()" :class="{ 'is-active': editor.isActive('orderedList') }">
                ordered list
            </button>
                <button class="rich-text-style-button" @click.prevent="editor.chain().focus().setTextAlign('left').run()" :class="{ 'is-active': editor.isActive({ textAlign: 'left' }) }">
                    left
                </button>
                <button class="rich-text-style-button" @click.prevent="editor.chain().focus().setTextAlign('center').run()" :class="{ 'is-active': editor.isActive({ textAlign: 'center' }) }">
                center
                </button>
                <button class="rich-text-style-button" @click.prevent="editor.chain().focus().setTextAlign('right').run()" :class="{ 'is-active': editor.isActive({ textAlign: 'right' }) }">
                    right
                </button>
            <button class="rich-text-style-button" @click.prevent="editor.chain().focus().undo().run()">
                undo
            </button>
            <button class="rich-text-style-button" @click.prevent="editor.chain().focus().redo().run()">
                redo
            </button>
        </div>
        <editor-content class="border rounded px-3 h-48 overflow-y-auto py-4" :editor="editor" />
    </div>
  </template>

  <script>
  import StarterKit from '@tiptap/starter-kit'
import Highlight from '@tiptap/extension-highlight'
import TextAlign from '@tiptap/extension-text-align'
import Underline from '@tiptap/extension-underline'
import { Color } from '@tiptap/extension-color'
import TextStyle from '@tiptap/extension-text-style'
  import { Editor, EditorContent } from '@tiptap/vue-3'

  export default {
    components: {
      EditorContent,
    },

    emits: ['update:modelValue'],

    props: {
        modelValue: {
            type: String,
            default: '',
        },
    },

    watch: {
        modelValue(value) {
            // HTML
            const isSame = this.editor.getHTML() === value

            // JSON
            // const isSame = JSON.stringify(this.editor.getJSON()) === JSON.stringify(value)

            if (isSame) {
                return
            }

            this.editor.commands.setContent(value, false)
        },
    },

    data() {
      return {
        editor: null,

      }
    },

    mounted() {
        this.editor = new Editor({
        extensions: [
            StarterKit,
            Highlight,
            Underline,
            TextStyle,
            Color,
            TextAlign.configure({
                types: ['heading', 'paragraph'],
            }),
        ],
      content: this.modelValue,
      onUpdate: () => {
        let html_value = this.editor.getHTML();
        let ret = html_value.replace('color: rgb(2, 2, 2)','');
        ret = ret.replace('<p></p>','<p><br></p>');
        console.log(ret)
        // HTML
        this.$emit('update:modelValue', ret)

        // JSON
        // this.$emit('update:modelValue', this.editor.getJSON())
      },
    })
    },

    beforeUnmount() {
      this.editor.destroy()
    },
  }
  </script>

  <style lang="scss">
  /* Basic editor styles */
  .ProseMirror {
    > * + * {
      margin-top: 0.75em;
      max-height: 192px;
      overflow-y: auto;
    }

    ul,
    ol {
      padding: 0 1rem;
    }

    h1 {
        display: block;
        font-size: 2em;
        margin-block-start: 0.67em;
        margin-block-end: 0.67em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        font-weight: bold;
    }

    h2 {
    display: block;
    font-size: 1.5em;
    margin-block-start: 0.83em;
    margin-block-end: 0.83em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}

h3 {
    display: block;
    font-size: 1.17em;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}

h4 {
    display: block;
    margin-block-start: 1.33em;
    margin-block-end: 1.33em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}

h5 {
    display: block;
    font-size: 0.83em;
    margin-block-start: 1.67em;
    margin-block-end: 1.67em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}

h6 {
    display: block;
    font-size: 0.67em;
    margin-block-start: 2.33em;
    margin-block-end: 2.33em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}

blockquote {
    display: block;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 40px;
    margin-inline-end: 40px;
    border-left: 3px solid #ddd;
    padding: 5px 0 5px 10px;
    margin: 15px 0 15px 15px;
}

    code {
      background-color: rgba(#616161, 0.1);
      color: #616161;
    }

    pre {
      background: #0D0D0D;
      color: #FFF;
      font-family: 'JetBrainsMono', monospace;
      padding: 0.75rem 1rem;
      border-radius: 0.5rem;

      code {
        color: inherit;
        padding: 0;
        background: none;
        font-size: 0.8rem;
      }
    }

    img {
      max-width: 100%;
      height: auto;
    }

    blockquote {
      padding-left: 1rem;
      border-left: 2px solid rgba(#0D0D0D, 0.1);
    }

    hr {
      border: none;
      border-top: 2px solid rgba(#0D0D0D, 0.1);
      margin: 2rem 0;
    }
    ul {
        list-style-type: disc;
    }
    ol {
        list-style-type: decimal;
    }
  }
  </style>
