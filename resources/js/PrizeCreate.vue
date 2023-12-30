<script>
    export default {
        data () {
            return {
                formContentsClass: 'createFormContents',
                formLabelClass: 'createFormInputLabel',
                formInputClass: 'createFormInput',
                inputName: 'name',
                inputCate: 'category',
                inputPPB: 'pricePerBox',
                inputSPB: 'snpPerBox',
                inputImg: 'image',
                submitName: '',
                submitCate: '',
                submitPPB: '',
                submitSPB: '',
                submitImg: '',
                createdPrizes: [],
                errors: [],
            }
        },

        methods: {
            CreatePrize () {
                if (!this.submitName || !this.submitCate || !this.submitPPB || !this.submitSPB) {
                    this.errors = [];

                    if (!this.submitName) {
                        this.errors.push('景品名を入力してください');
                    }

                    if (!this.submitCate) {
                        this.errors.push('カテゴリを入力してください');
                    }

                    if (!this.submitPPB) {
                        this.errors.push('箱単価を入力してください');
                    }

                    if (!this.submitSPB) {
                        this.errors.push('入り数を入力してください');
                    }

                    return false;
                }


                const url = 'http://localhost/create';
                axios.post(url, {
                    name: this.submitName,
                    category: this.submitCate,
                    pricePerBox: this.submitPPB,
                    snpPerBox: this.submitSPB,
                    img: this.submitImg

                }).then((response) => {
                    this.createdPrizes.push(
                        {
                            name: this.submitName,
                            category: this.submitCate,
                            pricePerBox: this.submitPPB,
                            snpPerBox: this.submitSPB
                        }
                    );
                    this.submitName =
                    this.submitCate =
                    this.submitPPB =
                    this.submitSPB =
                    this.submitImg = '';

                }).catch((error) => {
                    console.log(error);
                });
            },
            ImageToBinary (image) {
                const reader = new FileReader();
                const imgFile = image.target.files[0];

                if (image) {
                    reader.readAsDataURL(imgFile);
                } else {
                    this.submitImg = '';
                };

                reader.onload = () => {
                    this.submitImg = reader.result;
                }
            }
        },
    }
</script>

<template>
    <div id="createContainer">
        <form method="post" action="http://localhost/create">
            <div :class="formContentsClass">
                <label :for="inputName" :class="formLabelClass">景品名：</label>
                <input :id="inputName" :class="formInputClass" v-model='submitName' type="text" placeholder="30字以内"/>
            </div>
            <div :class="formContentsClass">
                <label :for="inputCate" :class="formLabelClass">カテゴリ：</label>
                <input :id="inputCate" :class="formInputClass" v-model='submitCate' type="text" placeholder="14字以内" />
            </div>
            <div :class="formContentsClass">
                <label :for="inputPPB" :class="formLabelClass">箱単価：</label>
                <input :id="inputPPB" :class="formInputClass" v-model='submitPPB' type="number" min="0" />
            </div>
            <div :class="formContentsClass">
                <label :for="inputSPB" :class="formLabelClass">入り数：</label>
                <input :id="inputSPB" :class="formInputClass" v-model='submitSPB' type="number" min="0" />
            </div>
            <div :class="formContentsClass" v-if='false'>
                <label :for="inputImg" :class="formLabelClass">画像：</label>
                <input :id="inputImg" :class="formInputClass" @change='ImageToBinary($event)' type="file" />
                <img :src='submitImg' />
            </div>
        </form>
        <button @click='CreatePrize'>作成</button>

        <ul v-if='errors'>
            <li v-for='error in errors'>
                {{ error }}
            </li>
        </ul>

        <table border="1">
            <colgroup>
                <col width="40%">
                <col width="25%">
                <col width="25%">
                <col width="10%">
            </colgroup>
            <tr>
                <td colspan="5">作成された景品</td>
            </tr>
            <tr v-if='createdPrizes.length == 0'>
                <td>　</td>
                <td>　</td>
                <td>　</td>
                <td>　</td>
            </tr>
            <tr v-for="(prize, index) in createdPrizes" :key=index>
                <td>{{ prize.name }}</td>
                <td>{{ prize.category }}</td>
                <td>{{ prize.pricePerBox }}</td>
                <td>{{ prize.snpPerBox }}</td>
            </tr>
        </table>
    </div>
</template>

<style>
    #createContainer {
        margin: 2rem 1rem;
    }

    .createFormContents {
        width: 25%;
        margin: 0.5rem 0;
    }

    .createFormInputLabel {
        display: inline-block;
        text-align: right;
        width: 35%;
    }

    .createFormInput {
        width: 65%;
    }

</style>
