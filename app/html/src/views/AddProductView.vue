<template>
  <main class="add-product">
    <form method="post" id="product_form">
      <div class="row g-3 align-items-center mb-3">
        <div class="col-auto flex-fill">
          <label class="form-label" for="sku">SKU</label>
        </div>
        <div class="col-auto control">
          <input class="form-control" type="text" name="sku" id="sku" required>
        </div>
      </div>

      <div class="row g-3 align-items-center mb-3">
        <div class="col-auto flex-fill">
          <label class="form-label" for="name">Name</label>
        </div>
        <div class="col-auto control">
          <input class="form-control" type="text" name="name" id="name" required>
        </div>
      </div>

      <div class="row g-3 align-items-center mb-3">
        <div class="col-auto flex-fill">
          <label for="price" class="form-label">Price ($)</label>
        </div>
        <div class="col-auto control">
          <input type="number" name="price" id="price" class="form-control" min="0" required>
        </div>
      </div>

      <div class="row g-3 align-items-center mb-3">
        <div class="col-auto flex-fill">
          <label for="productType" class="form-label">Type switcher</label>
        </div>
        <div class="col-auto control">
          <select name="type" id="productType" class="form-select" required @change="typeListener" ref="switcher">
            <option value="Book">Book</option>
            <option value="DVD">DVD</option>
            <option value="Furniture">Furniture</option>
          </select>
        </div>
      </div>

      <div id="dvd" class="group" data-hint="size">
        <div class="row g-3 align-items-center mb-3">
          <div class="col-auto flex-fill">
            <label for="size" class="form-label">Size</label>
          </div>
          <div class="col-auto control">
            <input type="number" name="size" id="size" class="form-control" required>
          </div>
        </div>
      </div>

      <div id="book" class="group" data-hint="weight">
        <div class="row g-3 align-items-center mb-3">
          <div class="col-auto flex-fill">
            <label for="weight" class="form-label">Weight</label>
          </div>
          <div class="col-auto control">
            <input type="number" name="weight" id="weight" class="form-control" required>
          </div>
        </div>
      </div>

      <div id="furniture" class="group" data-hint="dimensions">
        <div class="row g-3 align-items-center mb-3">
          <div class="col-auto flex-fill">
            <label for="height" class="form-label">Height</label>
          </div>
          <div class="col-auto control">
            <input type="number" name="height" id="height" class="form-control" required>
          </div>
        </div>
        <div class="row g-3 align-items-center mb-3">
          <div class="col-auto flex-fill">
            <label for="width" class="form-label">Width</label>
          </div>
          <div class="col-auto control">
            <input type="number" name="width" id="width" class="form-control" required>
          </div>
        </div>
        <div class="row g-3 align-items-center mb-3">
          <div class="col-auto flex-fill">
            <label for="length" class="form-label">Length</label>
          </div>
          <div class="col-auto control">
            <input type="number" name="length" id="length" class="form-control" required>
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <small class="form-text">Please, provide <span ref="hint">required fields</span></small>
      </div>
    </form>
  </main>
</template>

<script>
export default {
  methods: {
    typeListener(e) {
      const controlSelector = 'input, textarea, select';
      let selected = document.querySelector(`#${e.target.value.toLowerCase()}`)

      for (let group of document.querySelectorAll('#product_form .group')) {
        group.style.display = 'none';

        for (let input of group.querySelectorAll(controlSelector)) {
          input.disabled = true
        }
      }

      for (let input of selected.querySelectorAll(controlSelector)) {
        input.disabled = false;
      }

      if (selected) {
        selected.style.display = '';
        this.$refs.hint.style.display = '';
        this.$refs.hint.textContent = selected.dataset.hint;
      } else {
        this.$refs.hint.style.display = 'none';
      }
    }
  },
  mounted() {
    this.$refs.switcher.dispatchEvent(new Event('change'));

    for (let input of document.querySelectorAll('input, textarea, select')) {
      input.addEventListener('input', e => e.target.classList.remove('is-invalid'))
    }
  }
}
</script>

<style scoped>
.row {
  max-width: 350px;
}

.control {
  width: 60%;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type=number] {
  -moz-appearance: textfield;
}
</style>
