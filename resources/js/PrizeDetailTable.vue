<script>
    export default {
        data() {
            return {
                stocks: [],
                checkedData: [],
                checkedDataId: [],
                errors: [],
                newTaste: '',
                newExpired_at: '',
                newLimit_at: '',
                newMemo: '',
            }
        },

        props: {
            prize_id: '',
        },

        methods: {
            GetStockJsonData(id) {
                const url = 'http://localhost/getStockJsonData';
                axios.get(url, {
                params: {
                    prizeId: id,
                }
                }).then(response => {
                    this.stocks = response.data.stocks;
                });
            },
            GetCheckedData (checkData) {
                this.checkedData.push(checkData);
                this.checkedDataId.push(checkData.id);
                checkData.disabled = true;
            },
            CancelCheckedData (id) {
                const index = this.checkedDataId.indexOf(id);
                this.checkedData.splice(index, 1);
                this.checkedDataId.splice(index, 1);

                let enableDataIndex = '';
                this.stocks.some((stock, index) => {
                    if (stock['id'] == id) {
                        enableDataIndex = index;
                    }
                });

                if (this.stocks[enableDataIndex]) {
                    this.stocks[enableDataIndex].disabled = false;
                }
            },
            DataOperation (Operation) {

                const inputId = this.$refs.id;
                const inputMemo = this.$refs.memo;

                /** バリデーション */
                if (!inputId || inputId.length == 0) {
                    this.errors = [];
                    this.errors.push('操作するデータを選択してください');

                    return false;
                }

                /** 送信データ取得 */
                const id = [];
                const memo = [];
                for (let i = 0; i < inputId.length; i++) {
                    id.push(inputId[i].value);
                    memo.push(inputMemo[i].value);
                }

                /** データ送受信 */
                let url = '';
                if (Operation == 'edit') {
                    url = 'http://localhost/stockEdit';
                } else if (Operation == 'delete') {
                    url = 'http://localhost/stockDelete';
                }
                axios.post(url, {
                    submitId: id,
                    submitMemo: memo,
                }).then(response => {
                    this.GetStockJsonData(this.prize_id);
                })

                /** データリセット */
                this.checkedData = [];
                this.checkedDataId = [];

                /** 選択ボタンのdisabled切り替え */
                for (let i = 0; i < this.stocks.length; i++) {
                    if (this.stocks[i].disabled == true) {
                        this.stocks[i].disabled = false;
                    }
                }
            },
            SetLimit_at() {
                let date = new Date(this.newExpired_at);
                date.setDate(date.getDate() - 30);
                this.newLimit_at = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
            },
            StockAdd() {

                /** バリデーション */
                if (!this.newTaste || !this.newExpired_at) {
                    this.errors = [];
                    if (!this.newTaste) {
                        this.errors.push('味を入力してください');
                    }

                    if (!this.newExpired_at) {
                        this.errors.push('賞味期限を入力してください');
                    }

                    return false;
                }

                /** データ送受信 */
                const url = 'http://localhost/stockAdd';
                axios.post(url, {
                    submitPrize_id: this.prize_id,
                    submitTaste: this.newTaste,
                    submitExpired_at: this.newExpired_at,
                    submitMemo: this.newMemo,
                }).then(response => {
                    this.GetStockJsonData(this.prize_id);
                })

                /** データリセット */
                this.newTaste = '';
                this.newExpired_at = '';
                this.newLimit_at = '';
                this.newMemo = '';
            }
        },

        mounted() {
            this.GetStockJsonData(this.prize_id);
        }
    }
</script>

<template>
    <div id="detailContainer">
        <table border="1">
            <tr>
                <th>識別id</th>
                <th>味</th>
                <th>賞味期限</th>
                <th>使用期限</th>
                <th>概要</th>
                <th>選択</th>
            </tr>
            <tr v-for='(stock, index) in stocks'>
                <td>{{ stock.id }}</td>
                <td>{{ stock.taste }}</td>
                <td>{{ stock.expired_at }}</td>
                <td>{{ stock.limit_at }}</td>
                <td>{{ stock.memo }}</td>
                <td>
                    <button @click='GetCheckedData(stock)' v-bind='{disabled:stock.disabled}'>選択</button>
                </td>
            </tr>
            <tr>
                <td>追加する在庫</td>
                <td><input type="text" v-model="newTaste" placeholder="味：20字以内"/></td>
                <td><input type="date" v-model="newExpired_at" @change="SetLimit_at" placeholder="賞味期限" /></td>
                <td>{{ newLimit_at }}</td>
                <td><input type="text" v-model="newMemo" placeholder="概要：50字以内" /></td>
                <td></td>
            </tr>
        </table>
        <button @click="StockAdd">在庫追加</button>

        <ul v-if='errors'>
            <li v-for='error in errors'>
                {{ error }}
            </li>
        </ul>

        <table border="1">
            <colgroup>
                <col width="10%">
                <col width="20%">
                <col width="20%">
                <col width="30%">
                <col width="20%">
            </colgroup>
            <tr>
                <th>識別id</th>
                <th>味</th>
                <th>賞味期限</th>
                <th>概要</th>
                <th>キャンセル</th>
            </tr>
            <tr v-if='checkedData.length == 0'>
                <td>　</td>
                <td>　</td>
                <td>　</td>
                <td>　</td>
                <td>　</td>
            </tr>
            <tr v-for='(data, index) in checkedData'>
                <td><input type="hidden" ref="id" :value="data.id" />{{ data.id }}</td>
                <td>{{ data.taste }}</td>
                <td>{{ data.expired_at }}</td>
                <td><input type="text" ref="memo" :placeholder="data.memo" /></td>
                <td><button @click='CancelCheckedData(data.id)'>キャンセル</button></td>
            </tr>
        </table>

        <button @click="DataOperation('edit')">概要編集</button>
        <button @click="DataOperation('delete')">在庫削除</button>
    </div>
</template>
