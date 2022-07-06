<template>
  <main class="home">
    <section class="list row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 g-lg-4">
      <div class="col">
        <product-card sku="test" name="Testing product" price="1500 $" attribute="Dimensions: 10x10x5"
                      @set="listenCheckbox"/>
      </div><div class="col">
        <product-card sku="test" name="Testing product" price="1500 $" attribute="Dimensions: 10x10x5"
                      @set="listenCheckbox"/>
      </div><div class="col">
        <product-card sku="test" name="Testing product" price="1500 $" attribute="Dimensions: 10x10x5"
                      @set="listenCheckbox"/>
      </div><div class="col">
        <product-card sku="test" name="Testing product" price="1500 $" attribute="Dimensions: 10x10x5"
                      @set="listenCheckbox"/>
      </div><div class="col">
        <product-card sku="test" name="Testing product" price="1500 $" attribute="Dimensions: 10x10x5"
                      @set="listenCheckbox"/>
      </div><div class="col">
        <product-card sku="test" name="Testing product" price="1500 $" attribute="Dimensions: 10x10x5"
                      @set="listenCheckbox"/>
      </div><div class="col">
        <product-card sku="test" name="Testing product" price="1500 $" attribute="Dimensions: 10x10x5"
                      @set="listenCheckbox"/>
      </div>
      <div class="col">
        <product-card sku="test" name="Testing product" price="1500 $" attribute="Dimensions: 10x10x5"
                      @set="listenCheckbox"/>
      </div>
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
