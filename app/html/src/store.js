import {reactive} from "vue";

export const store = reactive({
    selected: [],
    products: [],
    getProducts() {
        fetch('/api/products')
            .then(response => response.json())
            .then(data => this.products = data.data)
            .catch(e => console.log(e));
    },
    deleteProducts(products) {
        let arrStr = products.map(function(el, idx) {
            return 'items[' + idx + ']=' + el;
        }).join('&');

        fetch('/api/products?' + arrStr, {
            method: 'DELETE'
        })
            .then(() => {
                this.getProducts();
                this.selected = [];
            })
    }
})