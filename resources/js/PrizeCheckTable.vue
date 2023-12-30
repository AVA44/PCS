<script>
    export default {
        data() {
            return {
                checkedPrizeData: [],
                checkedPrizeDataId: [],
                errors: [],
            }
        },

        props: {
            prizes: {},
            opeOrder: '',
        },

        emits: [
            'GetPrizes'
        ],

        methods: {
            GetCheckedData (prizeData, index) {
                this.checkedPrizeData.push(prizeData);
                this.checkedPrizeDataId.push(prizeData.id);
                prizeData.disabled = true;
            },
            CheckDataDestroy () {
                /** バリデーション */
                this.errors = [];
                if (this.checkedPrizeDataId.length == 0) {
                    this.errors.push('景品を選択してください');
                    return false;
                }

                /** データ送受信 */
                const url = 'http://localhost/delete';
                axios.post(url, {
                    id: this.checkedPrizeDataId,
                }).then(response => {
                    this.$emit('GetPrizes');
                });

                /** データリセット */
                this.checkedPrizeData = [];
                this.checkedPrizeDataId = [];
            },
            CancelCheckedData (id) {
                const index = this.checkedPrizeDataId.indexOf(id);
                this.checkedPrizeData.splice(index, 1);
                this.checkedPrizeDataId.splice(index, 1);

                let enablePrizeIndex = '';
                this.prizes.some((prize, index) => {
                    if (prize['id'] == id) {
                        enablePrizeIndex = index;
                    }
                });

                if (this.prizes[enablePrizeIndex]) {
                    this.prizes[enablePrizeIndex].disabled = false;
                }
            },
        },

        watch: {
            prizes(prizes) {
                prizes.forEach((prize) => {
                    if (this.checkedPrizeDataId.includes(prize.id)) {
                        prize.disabled = true;
                    }
                })
            }
        }
    }
</script>

<template>
    <div class="checkTableContainer">
        <table border='1'>
            <tr>
                <th>景品名</th>
                <th>カテゴリ</th>
                <th>入り数</th>
                <th>箱単価</th>
                <th>単位単価</th>
                <th>次の賞味期限</th>
                <th>次の使用期限</th>
                <th>残り日数</th>
                <th>選択</th>
            </tr>
            <tr v-for='(prize, index) in prizes' :key='prize.id'>
                <td>{{ prize.name }}</td>
                <td>{{ prize.category }}</td>
                <td>{{ prize.snp_per_box }}個</td>
                <td>{{ prize.price_per_box }}円</td>
                <td>{{ Math.round(prize.price_per_box / prize.snp_per_box) }}円</td>
                <td>{{ prize.expired_at }}</td>
                <td>{{ prize.limit_at }}</td>
                <td>{{ prize.daysLeft }}日</td>
                <td>
                    <button @click='GetCheckedData(prize, index)' v-bind='{disabled:prize.disabled}'>選択</button>
                </td>
            </tr>
        </table>
        <ul v-if='errors'>
            <li v-for='error in errors'>
                {{ error }}
            </li>
        </ul>
        <table border="1">
            <colgroup>
                <col width="50%">
                <col width="40%">
                <col width="10%">
            </colgroup>
            <tr>
                <th>景品名</th>
                <th>カテゴリ</th>
                <th>キャンセル</th>
            </tr>
            <tr v-if='checkedPrizeData.length == 0'>
                <td>　</td>
                <td>　</td>
                <td>　</td>
            </tr>
            <tr v-for='(prizeData, index) in checkedPrizeData'>
                <td>{{ prizeData.name }}</td>
                <td>{{ prizeData.category }}</td>
                <td><button @click='CancelCheckedData(prizeData.id)'>キャンセル</button></td>
            </tr>
        </table>
        <button v-if='opeOrder == "delete"' @click="CheckDataDestroy">削除</button>
    </div>
</template>
