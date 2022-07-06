<template>
  <main class="home">
    <section class="list row row-cols-4">
      <product-card class="col" sku="test" name="Testing product" price="1500 $" attribute="Dimensions: 10x10x5"
                    @set="listenCheckbox"/>
    </section>
  </main>
</template>

<script>
import ProductCard from "@/components/ProductCard";
import {store} from "@/store"

export default {
  name: 'HomeView',
  components: {ProductCard},
  data() {
    return {
      store
    }
  },
  methods: {
    listenCheckbox(checked, sku) {
      if (checked) this.store.selected.push(sku);
      else {
        let index = this.store.selected.indexOf(sku);
        if (index > -1) this.store.selected.splice(index, 1);
      }
    }
  },
  unmounted() {
    this.store.selected = [];
  }
}
</script>
