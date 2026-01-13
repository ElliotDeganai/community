<template>
  <div>
    <!-- Élément unique pour le widget Calendly -->
    <div ref="calendlyWidget" class="calendly-inline-widget" :data-url="calendlyUrl" style="min-width: 320px; height: 700px;"></div>
  </div>
</template>

<script>
export default {
  name: 'CalendlyWidget',
  props: {
    calendlyUrl: {
      type: String,
      required: true,
      default: 'https://calendly.com/edeganai/travaux-energetique' // Remplacez par votre URL Calendly par défaut
    }
  },
  data() {
    return {
      scriptLoaded: false // Suivre si le script est chargé
    };
  },
  mounted() {
    // Vérifier si le script Calendly est déjà chargé
    const existingScript = document.querySelector('script[src="https://assets.calendly.com/assets/external/widget.js"]');

    if (!existingScript) {
      // Charger le script dynamiquement
      const script = document.createElement('script');
      script.src = 'https://assets.calendly.com/assets/external/widget.js';
      script.async = true;
      script.onload = () => {
        this.initializeCalendly();
        this.scriptLoaded = true;
      };
      document.head.appendChild(script);
    } else {
      // Si le script est déjà chargé, initialiser directement
      this.initializeCalendly();
    }
  },
  methods: {
    initializeCalendly() {
      // Vérifier si window.Calendly existe et si le widget n'est pas déjà initialisé
      if (window.Calendly && this.$refs.calendlyWidget && !this.$refs.calendlyWidget.hasAttribute('data-processed')) {
        window.Calendly.initInlineWidget({
          url: this.calendlyUrl,
          parentElement: this.$refs.calendlyWidget
        });
        // Marquer l'élément comme traité pour éviter une réinitialisation
        this.$refs.calendlyWidget.setAttribute('data-processed', 'true');
      }
    }
  },
  beforeDestroy() {
    // Nettoyer le widget si nécessaire
    if (this.$refs.calendlyWidget) {
      this.$refs.calendlyWidget.innerHTML = ''; // Vider le contenu du widget
    }
  }
};
</script>

<style scoped>
.calendly-inline-widget {
  min-width: 320px;
  height: 700px;
}
</style>
