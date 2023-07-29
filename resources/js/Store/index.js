import { createApp } from 'vue'
import { createStore } from 'vuex'
import idb from '../FrontDb/indexedDBService';

// Create a new store instance.
const store = createStore({
    state: {
        delete_modal: false,
        model: null,
        delete_route: null,
        type: null,
        db: null,
        cart: [],
        cart_products: [],
        product: null
    },
    mutations: {
        SET_PRODUCT(state, product){
            state.delete_modal = true;
        },
        SET_PRODUCT_MODAL(state, product){
            state.product = product;
        },
        UNSET_PRODUCT_MODAL(state){
            state.product = null;
        },
        SET_CART_PRODUCTS(state, products){
            products.forEach(p => {
                state.cart_products.push(p);
            });
        },
        SET_PRODUCT_QANTITY(state, product){
            let product_in_cart = state.cart.filter(item => item.product.id == product.id);
            console.log(product_in_cart)
            if (product_in_cart.length == 0) {
                let cart_item = {
                    product: product,
                    quantity: 1
                };
                state.cart.push(cart_item );
            } else {
                state.cart.filter(item => item.product.id == product.id)[0].quantity++;
            }
        },
        SET_DELETE_MODAL(state){
            state.delete_modal = true;
        },
        UNSET_DELETE_MODAL(state){
            state.delete_modal = false;
        },
        SET_MODEL(state, model){
            state.model = model;
        },
        UNSET_MODEL(state){
            state.model = null;
        },
        SET_TYPE(state, type){
            state.type = type;
        },
        UNSET_TYPE(state){
            state.type = null;
        },
        SET_ROUTE(state, type){
            switch (type) {
                case 'template':
                    state.delete_route = 'categories.destroy';
                    break;
                case 'resource':
                    state.delete_route = 'posts.destroy';
                    break;
                case 'documentation':
                    state.delete_route = 'documentations.destroy';
                    break;
                case 'user':
                    state.delete_route = 'users.destroy';
                    break;
                case 'page':
                    state.delete_route = 'pages.destroy';
                    break;

                default:
                    break;
            }
        },
        UNSET_ROUTE(state){
            state.delete_route = null;
        },
    },
    actions: {
        setCartProducts({ commit, state }, products){
            commit('SET_CART_PRODUCTS', products);
        },
        async setDb(context){
          //context.state.saving = true;
          context.state.db = await idb.getDb();
          //await context.dispatch('checkObjectKey');
          //let translations = await idb.getTranslations();
          //context.commit('setTranslations', translations);
/*           setTimeout(function () {
            context.state.saving = false;
          }, 1000)   */
        },
        set_product ({ commit, state }, product) {
          commit('SET_PRODUCT_QANTITY', product);
        },
        set_product_modal ({ commit, state }, product) {
          commit('SET_PRODUCT_MODAL', product);
        },
        unset_product_modal ({ commit, state }) {
          commit('UNSET_PRODUCT_MODAL');
        },
        set_delete_modal ({ commit, state }) {
          commit('SET_DELETE_MODAL');
        },
        unset_delete_modal ({ commit, state }) {
          commit('UNSET_DELETE_MODAL');
        },
        set_model ({ commit, state }, model) {
          commit('SET_MODEL', model.model);
          commit('SET_DELETE_MODAL');
          commit('SET_ROUTE', model.route);
          commit('SET_TYPE', model.type);
        },
        unset_model ({ commit, state }) {
          commit('UNSET_MODEL');
          commit('UNSET_DELETE_MODAL');
          commit('UNSET_ROUTE');
          commit('UNSET_TYPE');
        },
        async deleteCartItem(context, cartItem) {
          await idb.deleteCartItem(cartItem);
          context.dispatch('getCartItems');
        },
        async deleteCartItems(context, cartItems) {
          await idb.deleteCartItems(cartItems);
          context.dispatch('getCartItems');
        },
        async getCartItems(context) {
          context.state.cart = [];
          let cartDb = await idb.getCartItems();
          cartDb.forEach(c => {
            let product = context.state.cart_products.filter(p => p.id == c.product)[0];
            context.state.cart.push({product: product, quantity: c.quantity, id: c.id});
          });
        },
        async saveCartItem(context, cartItem) {
          let test = null;
          const itemToAdd = {
            product: cartItem.product.id,
            quantity: 1
          };
            test = await idb.saveCartItem(itemToAdd);
            context.dispatch('getCartItems');
        },
        async addCartItemQuantity(context, cartItem) {
            cartItem.quantity++;
            const itemToAdd = {
                id: cartItem.id,
              product: cartItem.product.id,
              quantity: cartItem.quantity
            };
            await idb.editCartItem(itemToAdd);
            context.dispatch('getCartItems');
        },
        async reduceCartItemQuantity(context, cartItem) {
            cartItem.quantity--;
            const itemToAdd = {
                id: cartItem.id,
              product: cartItem.product.id,
              quantity: cartItem.quantity
            };
            if (cartItem.quantity > 0) {
                await idb.editCartItem(itemToAdd);
            }else{
                context.dispatch('deleteCartItem', itemToAdd);
            }
            context.dispatch('getCartItems');
        },
    }
})

export default store;
