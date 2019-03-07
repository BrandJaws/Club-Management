

<script>


    Vue.component('message-bar', {
        template: `

			<div role="alert" :class="['text-center','alert', type == 'success' ? 'alert-success' : (type == 'error' ? 'alert-warning' : '') ]" >
                     @{{ message }}
            </div>
                        `,
        props: [
            "type", //success or failure
            "message"
        ],
        methods: {


        }
    });
</script>