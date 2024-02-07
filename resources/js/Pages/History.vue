<script setup lang="ts">

import {Head, usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "../Layouts/AuthenticatedLayout.vue";
import {Account} from "../types";
import {useQuery} from "vue-query";
import {ref} from "vue";
import TransactionTable from "../Components/TransactionTable.vue";
import {getTransactions} from "../api";
import { MagnifyingGlassIcon } from '@heroicons/vue/20/solid'


interface HistoryProps {
    account: Account;
}

defineProps<HistoryProps>();

const page = usePage();
const search = ref<string>('');
const query = ref<string>('');
const limit = ref<number>(100);
const pageNumber = ref<number>(1);
const orderBy = ref<string>('created_at');
const direction = ref<string>('desc');

const setSort = (column: string) => {
    if (orderBy.value === column) {
        direction.value = direction.value === 'asc' ? 'desc' : 'asc';
    } else {
        orderBy.value = column;
        direction.value = 'asc';
    }
};

const changeLimit = (value: number) => {
    limit.value = value;
};

const changePage = (value: number) => {
    pageNumber.value = value;
};

const setQuery = () => {
    query.value = search.value;
};

const {isLoading, data, error} = useQuery(
    ["transaction", page.props.account.id, direction, limit, pageNumber, query, orderBy],
    () => getTransactions({
        accountId: page.props.account.id,
        limit: limit.value,
        offset: (pageNumber.value - 1) * limit.value,
        query: query.value,
        direction: direction.value,
        orderBy: orderBy.value
    })
);
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <div>
                History - {{ account.name }} {{ account.balance }}$
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-4">
                    <form @submit.prevent="setQuery">
                        <label for="search" class="block text-sm font-medium leading-6 text-gray-900">Quick search</label>
                        <div class="relative mt-2 flex items-center">
                            <input v-model="search" type="text" name="search" id="search" class="block w-full rounded-md border-0 py-1.5 pr-14 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                            <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                                <button type="submit" class="rounded-full bg-indigo-600 p-1 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    <MagnifyingGlassIcon class="h-3 w-4" aria-hidden="true" />
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <TransactionTable
                    :data="data?.transactions ?? []"
                    :is-loading="isLoading"
                    :direction="direction"
                    :order-by="orderBy"
                    :total="data?.total ?? 0"
                    :page="pageNumber"
                    @setSort="setSort"
                    @change-limit="changeLimit"
                    @change-page="changePage"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
