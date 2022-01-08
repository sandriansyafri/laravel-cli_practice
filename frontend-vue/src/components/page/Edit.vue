<template>
    <div class="container my-5 mb-3">
        <div class="row mb-3">
            <div class="col">
                <h1>Edit</h1>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <router-link class="btn btn-primary py-2 px-4" :to="{ name: 'transaction.index' }">Back</router-link>
            </div>
        </div>
        <div class="row">
            <div class="col-10">
                <div class="card shadow-sm bg-body rounded">
                    <div class="card-header">Create Form</div>
                    <div class="card-body">
                        <form @submit.prevent="update()">
                            <div class="mb-3">
                                <label for="">Title </label>
                                <input type="text" name="title" class="form-control" v-model="transaction.title" />
                                <span v-if="validation.title" class="text-danger">{{ validation.title[0] }}</span>
                            </div>
                            <div class="mb-3">
                                <label for="">Amount</label>
                                <input type="number" name="amount" class="form-control" v-model="transaction.amount" />
                                <span v-if="validation.amount" class="text-danger">{{ validation.amount[0] }}</span>
                            </div>
                            <div class="mb-3">
                                <label for="">Type</label>
                                <select name="type" v-model="transaction.type" id="" class="form-select">
                                    <option value="expense">Expense</option>
                                    <option value="revenue">Revenue</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, reactive, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
export default {
    setup() {
        let transaction = reactive({
            title: "",
            amount: "",
            type: "",
        });

        const router = useRouter();
        const route = useRoute();
        const validation = ref([]);

        function update() {
            axios
                .put(`http://127.0.0.1:8000/api/transaction/${route.params.id}`, transaction)
                .then((res) => {
                    router.push({
                        name: "transaction.index",
                    });
                })
                .catch((e) => {
                    validation.value = e.response.data;
                });
        }

        onMounted(() => {
            const id = route.params.id;

            axios.get(`http://127.0.0.1:8000/api/transaction/${id}`).then((res) => {
                transaction.title = res.data.data.title;
                transaction.amount = res.data.data.amount;
                transaction.type = res.data.data.type;
            });
        });

        return {
            transaction,
            validation,
            update,
            route,
            router,
        };
    },
};
</script>

<style></style>
