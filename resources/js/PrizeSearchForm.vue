<script>
    export default {
        data() {
            return {
                searchKey: '',
                searchCate: '',
                prizes: {},
            }
        },

        emits: ['submitPrizeData'],

        methods: {
            GetPrizeJsonData() {
                const url = 'http://localhost/getPrizeJsonData';
                axios.get(url, {
                params: {
                    key: this.searchKey,
                    cate: this.searchCate,
                }
                }).then(response => {
                    this.prizes = response.data.prizes
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
    <form>
        <div>
            <p>キーワード：</p>
            <input type="text" @input='InputSearchKey' />
        </div>
        <div>
            <p>カテゴリ：</p>
            <select @change='InputSearchCate'>
                <option value="">全部</option>
                <option value="category1">1</option>
                <option value="category2">2</option>
                <option value="category3">3</option>
                <option value="category4">4</option>
            </select>
        </div>
    </form>
    <button @click='GetPrizeJsonData'>検索</button>
</template>
