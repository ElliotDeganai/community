<template>
  <ul class="flex flex-wrap justify-center">
    <li class="">
      <button class="p-2 text-center" type="button" @click.prevent="onClickFirstPage()" :disabled="isInFirstPage">First</button>
    </li>

    <li>
      <button class="p-2 text-center" type="button" @click.prevent="onClickPreviousPage()" :disabled="isInFirstPage">Previous</button>
    </li>

    <!-- Visible Buttons Start -->

    <li v-for="page in pages" :key="page.name">
      <button :class="[page.name === currentPage ? 'font-bold text-purple-300' : '']" class="p-2 text-center" type="button" @click.prevent="onClickPage(page.name)" :disabled="page.isDisabled"> {{ page.name }} </button>
    </li>

    <!-- Visible Buttons End -->

    <li>
      <button class="p-2 text-center" type="button" @click.prevent="onClickNextPage()" :disabled="isInLastPage"> Next </button>
    </li>

    <li>
      <button class="p-2 text-center" type="button" @click.prevent="onClickLastPage()" :disabled="isInLastPage"> Last </button>
    </li>
  </ul>
</template>

<script>
export default {
  props: {
    maxVisibleButtons: {
      type: Number,
      required: false,
      default: 3
    },    
    totalPages: {
      type: Number,
      required: true
    },
    perPage: {
      type: Number,
      required: true
    },
    currentPage: {
      type: Number,
      required: true
    },
    type: {
      type: String,
      required: true
    }
  },
  computed: {
    startPage() {
      // When on the first page
      if (this.currentPage === 1) {
        return 1;
      }

      // When on the last page
      if (this.currentPage === this.totalPages) {
        return this.totalPages - this.maxVisibleButtons;
      }

      // When inbetween
      return this.currentPage - 1;
    },
    pages() {
      const range = [];
      for (let i = this.startPage; i <= Math.min(this.startPage + this.maxVisibleButtons - 1, this.totalPages);i++) {
        range.push({
          name: i,
          isDisabled: i === this.currentPage
        });
      }
      return range;
    },
    isInFirstPage() {
      return this.currentPage === 1;
    },
    isInLastPage() {
      return this.currentPage === this.totalPages;
    },
    urlBase() {
        if(this.type === 'news') {
            return '/news/'
        }else {
            return '/shop/'
        }
    },
  },
  methods: {
    onClickFirstPage() {
      //this.$emit('pagechanged', 1);
      this.$router.push(this.urlBase+'1');
    },
    onClickPreviousPage() {
      //this.$emit('pagechanged', this.currentPage - 1);
      this.$router.push(this.urlBase+Number(this.currentPage - 1));
    },
    onClickPage(page) {
      //this.$emit('pagechanged', page);
      this.$router.push(this.urlBase+ page);
    },
    onClickNextPage() {
      //this.$emit('pagechanged', this.currentPage + 1);
      this.$router.push(this.urlBase+Number(this.currentPage + 1));
    },
    onClickLastPage() {
      //this.$emit('pagechanged', this.totalPages);
      this.$router.push(this.urlBase+this.totalPages);
    }
  }
};
</script>