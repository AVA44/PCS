<script>
    export default {
        data() {
            return {
                detailUrl: 'https://pcs-app.fly.dev/detail/',
                limit: 'limit',
                closeLimit: 'scloseLimit',
            }
        },
        props: {
            prizes: {},
        },
    }
</script>

<template>
    <table border="1">
        <tr>
            <th>景品名</th>
            <th>カテゴリ</th>
            <th>入り数</th>
            <th>箱単価</th>
            <th>単位単価</th>
            <th>次の賞味期限</th>
            <th>次の使用期限</th>
            <th>残り日数</th>
        </tr>
        <tr
            v-for='prize in prizes'
            :key=prize.id
            :class='{ limit: prize.daysLeft < 0, closeLimit: prize.daysLeft >= 0 && prize.daysLeft < 30 }'
        >
            <td><a :href="detailUrl + prize.id">{{ prize.name }}</a></td>
            <td>{{ prize.category }}</td>
            <td>{{ prize.snp_per_box }}個</td>
            <td>{{ prize.price_per_box }}円</td>
            <td>{{ Math.round(prize.price_per_box / prize.snp_per_box) }}円</td>
            <td>{{ prize.expired_at }}</td>
            <td>{{ prize.limit_at }}</td>
            <td>{{ prize.daysLeft }}日</td>
        </tr>
    </table>
</template>

<style>
    table {
        width: 100%;
        text-align: center;
        margin: 2rem 0;
    }

    .closeLimit {
        background-color: #ffb9b9;
    }

    .limit {
        background-color: #9f9f9f;
    }
</style>
