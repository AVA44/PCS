<script>
    export default {
        data () {
            return {
                formElementClass: 'createFormElement',
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
バリデーションの作成
画像以外必須
    <form method="post" action="http://localhost/create">
        <div :class="formElementClass">
            <label :for="inputName">景品名：</label>
            <input :id="inputName" v-model='submitName' type="text" placeholder="30字以内"/>
        </div>
        <div :class="formElementClass">
            <label :for="inputCate">カテゴリ：</label>
            <input :id="inputCate" v-model='submitCate' type="text" placeholder="14字以内" />
        </div>
        <div :class="formElementClass">
            <label :for="inputPPB">箱単価：</label>
            <input :id="inputPPB" v-model='submitPPB' type="number" min="0" />
        </div>
        <div :class="formElementClass">
            <label :for="inputSPB">入り数：</label>
            <input :id="inputSPB" v-model='submitSPB' type="number" min="0" />
        </div>
        <div :class="formElementClass">
            <label :for="inputImg">画像：</label>
            <input :id="inputImg" @change='ImageToBinary($event)' type="file" />
            <img :src='submitImg' />
        </div>
    </form>
    <button @click='CreatePrize'>作成</button>

    <ul v-if='errors'>
        <li v-for='error in errors'>
            {{ error }}
        </li>
    </ul>

    <table>
        <tr>作成された景品</tr>
        <tr v-for="(prize, index) in createdPrizes" :key=index>
            <td>{{ prize.name }}</td>
            <td>{{ prize.category }}</td>
            <td>{{ prize.pricePerBox }}</td>
            <td>{{ prize.snpPerBox }}</td>
        </tr>
    </table>
</template>
