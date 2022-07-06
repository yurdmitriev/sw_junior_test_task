<template>
  <header class="container p-3 d-flex align-items-center justify-content-between border-bottom">
    <h1>{{ $route.meta.title }}</h1>
    <div class="buttons d-flex gap-2" v-if="$route.name === 'home'">
      <button type="button" class="btn btn-primary" @click="$router.push('/add-product')">Add</button>
      <button type="button" class="btn btn-danger" :disabled="store.selected.length === 0">Mass delete</button>
    </div>
    <div class="buttons d-flex gap-2" v-if="$route.name === 'add'">
      <button type="button" class="btn btn-primary" @click="submitForm">Add</button>
      <button type="button" class="btn btn-danger" @click="$router.push('/')">Cancel</button>
    </div>
  </header>
  <router-view class="container p-4"/>
  <footer class="container text-center p-3 border-top mt-auto">
    <p>Scandiweb Test assignment</p>
  </footer>
</template>

<script>
import {store} from "@/store";

export default {
  data() {
    return {
      store
    }
  },
  methods: {
    submitForm() {
    }
  }
}
</script>

<style>
#app {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}
</style>
