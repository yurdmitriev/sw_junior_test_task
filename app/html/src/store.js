import {reactive} from "vue";

export const store = reactive({
    selected: [],
    deleteProducts(products) {
        let arrStr = products.map(function(el, idx) {
            return 'items[' + idx + ']=' + el;
        }).join('&');

        fetch('http://products-app.local/api/products?' + arrStr, {
            method: 'DELETE'
        }).then(response => response.json()).then(data => console.log(data))
    }
})