<template>
  <main class="home">
    <section class="list row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 g-lg-4">
      <div class="col" v-for="product in products" :key="product.sku">
        <product-card :sku="product.sku" :name="product.name" :price="product.price" :attribute="product.attribute"
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
      store,
      products: []
    }
  },
  methods: {
    listenCheckbox(checked, sku) {
      if (checked) this.store.selected.push(sku);
      else {
        let index = this.store.selected.indexOf(sku);
        if (index > -1) this.store.selected.splice(index, 1);
      }
    },
    getProducts() {
      fetch('http://products-app.local/api/products')
          .then(response => response.json())
          .then(data => this.products = data.data)
          .catch(e => console.log(e));
    }
  },
  beforeMount() {
    this.getProducts()
  },
  unmounted() {
    this.store.selected = [];
  }
}
</script>
