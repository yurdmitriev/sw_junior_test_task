<template>
  <header class="navbar navbar-light bg-white sticky-top p-3 border-bottom">
    <div class="container flex-nowrap g-4">
      <h1 class="m-0">{{ $route.meta.title }}</h1>
      <div class="buttons d-flex gap-2" v-if="$route.name === 'home'">
        <button type="button" class="btn btn-primary" @click="$router.push('/add-product')">ADD</button>
        <button type="button" class="btn btn-danger" @click="massDelete">MASS DELETE</button>
      </div>
      <div class="buttons d-flex gap-2" v-if="$route.name === 'add'">
        <button type="button" class="btn btn-primary" @click="submitForm">Save</button>
        <button type="button" class="btn btn-danger" @click="cancel">Cancel</button>
      </div>
    </div>
  </header>
  <router-view class="container p-4"/>
  <footer class="text-center p-3 border-top mt-auto">
    <p>Scandiweb Test assignment</p>
  </footer>
  <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" ref="toast">
      <div class="toast-body" ref="toastBody">
        There must be an alert message
      </div>
    </div>
  </div>
</template>

<script>
import {store} from "@/store";
import {Toast} from "bootstrap";

export default {
  data() {
    return {
      store
    }
  },
  methods: {
    massDelete() {
      if (this.store.selected) this.store.deleteProducts(this.store.selected);
    },
    cancel() {
      const form = document.querySelector('#product_form');
      if (form) form.reset();
      this.$router.push('/')
    },
    submitForm() {
      const form = document.querySelector('#product_form');
      const data = new FormData(form);
      const toast = new Toast(this.$refs.toast, {delay: 2000});
      const empty = [];

      this.$refs.toast.addEventListener('hidden.bs.toast', function (e) {
        e.target.className = 'toast';
      })

      for (let [key, value] of data) {
        if (value) continue;

        document.querySelector(`#${key}`).classList.add('is-invalid');
        empty.push(key);
      }

      if (form.checkValidity()) {
        fetch('/api/products', {
          method: 'POST',
          body: data
        })
            .then(response => {
              if (response.ok) {
                form.reset();
                this.$router.push('/');
                this.$refs.toast.classList.add('bg-success', 'text-white');
              } else {
                this.$refs.toast.classList.add('bg-danger', 'text-white');
              }
            });
      } else {
        if (empty) this.$refs.toastBody.innerText = "Please, submit required data";
        else this.$refs.toastBody.innerText = "Please, provide the data of indicated type";

        this.$refs.toast.classList.add('bg-danger', 'text-white');
        toast.show();
      }
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

header h1 {
  text-overflow: ellipsis;
  white-space: nowrap;
  overflow: hidden;
}
</style>
