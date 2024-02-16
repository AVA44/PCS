<script>
    export default {
        data() {
            return {
                searchKey: '',
                searchCate: '',
                prizes: {},
                categories: {},
            }
        },

        emits: ['submitPrizeData'],

        methods: {
            GetPrizeJsonData() {
                /** 景品データ送受信 */
                const url = 'https://pcs-app.fly.dev/getPrizeJsonData';
                axios.get(url, {
                params: {
                    key: this.searchKey,
                    cate: this.searchCate,
                }
                }).then(response => {
                    this.prizes = response.data.prizes
                    this.categories = response.data.categories
                    this.$emit('submitPrizeData', this.prizes);
                });
            },
            InputSearchKey(e) {
                this.searchKey = e.target.value;
            },
            InputSearchCate(e) {
                this.searchCate = e.target.value;
            },
        },

        mounted() {
            this.GetPrizeJsonData();
        }
    }
</script>

<template>
    <div id="searchFormContainer">
        <form>
            <div class="searchFormContents">
                <p class="searchFormInputLabel">キーワード：</p>
                <input class="searchFormInput" type="text" @input='InputSearchKey' />
            </div>
            <div class="searchFormContents">
                <p class="searchFormInputLabel">カ テ ゴ リ：</p>
                <select class="searchFormInput" @change='InputSearchCate'>
                    <option value="">全部</option>
                    <option v-for='category in categories' :value=category>{{ category }}</option>
                </select>
            </div>
        </form>
        <button @click='GetPrizeJsonData'>検索</button>
    </div>
</template>

<style>
    #searchFormContainer {
        margin-bottom: 1rem;
    }

    .searchFormContents {
        display: flex;
        align-items: center;
        width: 20rem;
        height: 2rem;
        margin: 2rem 0;
    }

    .searchFormInputLabel {
        text-align: right;
        width: 30%;
    }

    .searchFormInput {
        width: 40%;
    }
</style>
