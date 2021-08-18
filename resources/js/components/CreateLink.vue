<template>
    <div class="container">
        <form @submit.prevent="handleRun" action="#">
            <div class="input-group mb-3">
                <input required v-model="url" type="text" class="form-control" placeholder="https://example.com/post" aria-label="Put link" aria-describedby="button-addon">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon">Run</button>
            </div>
        </form>
        <template v-if="shortUrl">
            <div class="input-group mb-3">
                <input class="form-control" type="text" v-model="shortUrl" ref="shortUrl" aria-describedby="button-copy">
                <button @click="handleCopy" class="btn btn-outline-secondary" type="button" id="button-copy">Copy</button>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    name: "CreateLink",
    data: () => {
        return {
            url: '',
            shortUrl: ''
        }
    },
    methods: {
        handleRun() {
            this.shortUrl = ''
            this.createShortLink()
        },

        handleCopy() {
            this.$refs.shortUrl.select();
            document.execCommand("copy");
        },

        createShortLink() {
            this.postData('/api/create-link', {url: this.url}).then((response) => {
                if (typeof response.shortUrl != "undefined") {
                    this.shortUrl = response.shortUrl
                } else {
                    console.log('error')
                }
            }).catch(reason => {
                console.log(reason)
            })
        },

        async postData(url = '', data = {}) {
            let response = await fetch(url, {
                'method': 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                'body': JSON.stringify(data),

            })

            return await response.json()
        }
    }
}
</script>

<style scoped>

</style>
