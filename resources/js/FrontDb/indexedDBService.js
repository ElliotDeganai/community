const DB_NAME = 'cartdb';
const DB_VERSION = 1;
let DB;

export default {

    serialize(value) {
        console.log(typeof value)
        if (typeof value === 'function') {
            return value.toString();
        }
        if (typeof value !== 'function') {
            var serializeObject = {};
            for (const [objectKey, objectValue] of Object.entries(value)) {
                console.log(`objectKey=${objectKey}  value=${objectValue}`);
                if (objectValue == null || objectValue == undefined) {
                    serializeObject[objectKey] = null;
                } else {
                    serializeObject[objectKey] = this.serialize(objectValue);
                }
            }
            return serializeObject;
        }

        return value;
    },

	async getDb() {
		return new Promise((resolve, reject) => {

			if(DB) { return resolve(DB); }
			console.log('OPENING DB', DB);
			let request = window.indexedDB.open(DB_NAME, DB_VERSION);

			request.onerror = e => {
				console.log('Error opening db', e);
				reject('Error');
			};

			request.onsuccess = e => {
				DB = e.target.result;
				resolve(DB);
			};

			request.onupgradeneeded = e => {
				console.log('onupgradeneeded');
				let db = e.target.result;
				db.createObjectStore("cartItems", { autoIncrement: true, keyPath:'id' });
			};
		});
	},
	async deleteCartItem(cartItem) {

		let db = await this.getDb();

		return new Promise(resolve => {

			let trans = db.transaction(['cartItems'],'readwrite');
			trans.oncomplete = () => {
				resolve();
			};

			let store = trans.objectStore('cartItems');
			store.delete(cartItem.id);
		});
	},
	async deleteCartItems(cartItems) {

		let db = await this.getDb();

		return new Promise(resolve => {

			let trans = db.transaction(['cartItems'],'readwrite');
			trans.oncomplete = () => {
				resolve();
			};

			let store = trans.objectStore('cartItems');
			for (let index = 0; index < cartItems.length; index++) {
				const element = cartItems[index];
				store.delete(cartItems[index].id);
			}
		});
	},
	async getCartItems() {

		let db = await this.getDb();

		return new Promise(resolve => {

			let trans = db.transaction(['cartItems'],'readonly');
			trans.oncomplete = () => {
				resolve(cartItems);
			};

			let store = trans.objectStore('cartItems');
			let cartItems = [];

			store.openCursor().onsuccess = e => {
				let cursor = e.target.result;
				//console.log(cursor)
				if (cursor) {
					cartItems.push(cursor.value)
					cursor.continue();
				}
			};

		});
	},

	async saveCartItem(cartItem) {

		let db = await this.getDb();

		return new Promise(resolve => {

			let trans = db.transaction(['cartItems'],'readwrite');
			trans.oncomplete = () => {
				resolve();
			};
			//console.log(cartItem)
			let store = trans.objectStore('cartItems');
			let test = store.add(cartItem);
			//console.log(test)
			return test;

		});

	},

	async editCartItem(cartItem) {

		let db = await this.getDb();

		return new Promise(resolve => {
			let trans = db.transaction(['cartItems'],'readwrite');
			trans.oncomplete = () => {
				resolve();
			};
			let store = trans.objectStore('cartItems');
			const objectStoreRequest = store.get(cartItem.id);
			objectStoreRequest.onsuccess = () => {
				// Grab the data object returned as the result
				const data = objectStoreRequest.result;
				console.log(data)
				// Update the notified value in the object to "yes"
				//data.notified = "yes";
                data.quantity++;
				const updateTitleRequest = store.put(data);
			  };
		});
	},
	async getCartItem(cartItemId) {

		let db = await this.getDb();

		return new Promise(resolve => {
			let trans = db.transaction(['cartItems'],'readwrite');
			trans.oncomplete = () => {
				resolve();
			};
			let store = trans.objectStore('cartItems');
			const objectStoreRequest = store.get(cartItemId);

			store.openCursor().onsuccess = e => {
				let cursor = e.target.result;
				if (cursor) {
					//cartItems.push(cursor.value)
					cursor.continue();
				}
			};

		});
	},

}
