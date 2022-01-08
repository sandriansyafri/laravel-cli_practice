<template>
    <div class="container my-5 mb-3">
        <div class="row mb-3">
            <div class="col">
                <h1>Transaction</h1>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <router-link class="btn btn-primary py-2 px-4" :to="{ name: 'transaction.create' }">Add</router-link>
            </div>
        </div>
        <div class="row">
            <div class="col-10">
                <div class="card shadow-sm bg-body rounded">
                    <div class="card-body">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(transaction, index) in transactions" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ transaction.title }}</td>
                                    <td>{{ transaction.amount }}</td>
                                    <td>{{ transaction.type }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <router-link :to="{ name: 'transaction.edit', params: { id: transaction.id } }" class="btn btn-success btn-sm">Edit</router-link>
                                            <button @click="destroy(transaction.id, index)" class="btn btn-danger btn-sm">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
export default {
    setup() {
        let transactions = ref([]);
        onMounted(() => {});
        axios
            .get(`http://127.0.0.1:8000/api/transaction`)
            .then((res) => {
                transactions.value = res.data.data;
            })
            .catch((e) => {
                console.log(e);
            });

        function destroy(id, index) {
            axios.delete(`http://127.0.0.1:8000/api/transaction/${id}`).then((res) => {
                transactions.value.splice(index, 1);
            });
        }

        return {
            transactions,
            destroy,
        };
    },
};
</script>

<style></style>
