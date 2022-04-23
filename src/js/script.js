loadProgressBar()

Vue.component('validation-observer', VeeValidate.ValidationObserver);
Vue.component('validation-provider', VeeValidate.ValidationProvider);

Object.keys(VeeValidateRules).forEach(rule => {
   VeeValidate.extend(rule, VeeValidateRules[rule]);
});

var app = new Vue({
    el: '#app',
    data: {
       title: 'WP Auto Post Demo',
       preview: null,
       post: {
           title: null,
           description: null,
           image: null
       },
       submitting: false
    },
    methods: {
        async previewImage (e) {
           
           const { valid } = await this.$refs.postimg.validate(e);

           if (valid) {
               let input = e.target;

               if (input.files) {                                
                   let reader = new FileReader();
                   reader.onload = (e) => {
                       this.preview = e.target.result;
                   }

                   this.post.image = input.files[0];
                   reader.readAsDataURL(this.post.image);
                     
               }
           }
        },
        async submitPost () {
            console.log('form is submitted!')

            // prepare post data
            let formData = new FormData()

            formData.append('title', this.post.title)
            formData.append('description', this.post.description)
            formData.append('image', this.post.image)

            this.submitting = true

            // axios here
            try {
               const res = await axios.post('api/', formData, {
                   headers: {
                       'Content-Type': 'multipart/form-data'
                   }
               })

               console.log(res)

               if (!res.data.status) {
                    throw res.data.message
               }

               let confirmres = await Swal.fire({
                    title: 'Success',
                    icon: 'success',
                    html: res.data.message
               })

               if (confirmres.isConfirmed) {
                    location.reload()
               }

            } catch (err) {
                console.error(err)

                Swal.fire({
                   icon: 'error',
                   title: 'Oops...',
                   text: err,
                })
                
                this.submitting = false
                //return false
            }
        }
    }
})