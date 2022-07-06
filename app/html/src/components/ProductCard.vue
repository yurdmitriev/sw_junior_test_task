<template>
  <div class="item card">
    <div class="card-body text-center">
      <div class="form-check">
        <input type="checkbox" name="delete" :value="sku" class="delete-checkbox form-check-input" @change="$emit('set', $event.target.checked, sku)">
      </div>
      <div class="sku">{{sku}}</div>
      <div class="name">{{name}}</div>
      <div class="price">{{price}}</div>
      <div class="attribute">{{attribute}}</div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProductCard",
  props: ['sku', 'name', 'price', 'attribute']
}
</script>

<style scoped>

</style>