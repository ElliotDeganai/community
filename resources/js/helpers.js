const helpers = {
    getProductImage: function(product){
        return product.doc_values.filter(val => val.value_image === 1)[0].medias[0].original_url
    },
    getProductPrice: function(product){
        return product.doc_values.filter(val => val.value_image === 1)[0].medias[0].original_url
    },
    getImageUrl(product) {
        return product.doc_values.filter(val => val.value_image === 1)[0].medias[0].original_url
    },
    getImageUrl(product) {
        return product.doc_values.filter(val => val.value_image === 1)[0].medias[0].original_url
    },
    getAudioUrl(product) {
        return product.doc_values.filter(val => val.value_audio === 1)[0].medias[0].original_url
    },
    getDocValue( section, post, field_name) {
        let self = this;
        return this.getValue(post.doc_values.filter(val => val.documentation_id === self.getSectionField(section, field_name).documentation_id)[0]);
    },
    getSectionField(section, field_name) {
        return section.page_fields.filter(field => field.name === field_name)[0];
    },
    getValue(doc_value) {
        if (doc_value !== undefined && doc_value.value_text !== null) {
            return {
                docValue: doc_value.value_text,
                type: 'text'
            };
        } else if(doc_value.value_link !== null) {
            return {
                docValue: doc_value.value_link,
                type: 'link'
            };
        } else if(doc_value.value_price !== null) {
            return {
                docValue: doc_value.value_price,
                type: 'price'
            };
        } else if(doc_value.value_number !== null) {
            return  {
                docValue: doc_value.value_number,
                type: 'number'
            };
        } else if(doc_value.value_html !== null) {
            return  {
                docValue: doc_value.value_html,
                type: 'html'
            };
        } else if(doc_value.value_date !== null) {
            return {
                docValue: doc_value.value_date,
                type: 'date'
            };
        } else if(doc_value.value_date_time !== null) {
            return {
                docValue: doc_value.value_date_time,
                type: 'date_time'
            };
        } else if(doc_value.value_image !== null) {
            return {
                docValue: doc_value.value_image,
                type: 'image',
                medias: doc_value.medias
            };
        } else if(doc_value.value_gallery !== null) {
            return {
                docValue: doc_value.value_gallery,
                type: 'gallery',
                medias: doc_value.medias
            };
        } else if(doc_value.value_carousel !== null) {
            return {
                docValue: doc_value.value_carousel,
                type: 'carousel',
                medias: doc_value.medias
            };
        } else if(doc_value.value_audio !== null) {
            return {
                docValue: doc_value.value_audio,
                type: 'audio',
                medias: doc_value.medias,
                id: doc_value.id
            };
        }
    },
    getPrice(docValues) {
        return docValues.filter(d => d.value_price !== null)[0].value_price;
    },
    getDocValueByDocumentation(doc_values, documentation){
        return doc_values.filter(val => val.documentation_id === documentation.id)[0];
    },
    getSection(page, section_name){
        return page.page_sections.filter(section => section.name === section_name)[0];
    },

    getFieldDocValue(field, post){
        let docValue = '';
        this.getValue(post.doc_values.filter(doc => doc.documentation_id == field.documentation_id)[0]) ? docValue = this.getValue(post.doc_values.filter(doc => doc.documentation_id == field.documentation_id)[0]).docValue : docValue = '';
        return docValue;
    },

    getFieldDocValueObject(field, post){
        let docValue = '';
        this.getValue(post.doc_values.filter(doc => doc.documentation_id == field.documentation_id)[0]) ? docValue = this.getValue(post.doc_values.filter(doc => doc.documentation_id == field.documentation_id)[0]) : docValue = '';
        return docValue;
    },
}

export default helpers;
