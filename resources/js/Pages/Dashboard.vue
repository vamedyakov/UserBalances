<script setup lang="ts">
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue';
import {Head, usePage} from '@inertiajs/vue3';
import {ref} from "vue";
import TransactionList from "../Components/TransactionList.vue";
import {useQuery} from "vue-query";
import {Account} from "../types";
import {getTransactions} from "../api";

interface DashboardProps {
    accounts: Account[];
}

defineProps<DashboardProps>();

const page = usePage()
const defaultAccount = page.props.accounts?.find(account => account.is_default);
const currentAccount = ref<number>(defaultAccount?.id ?? 0);

const {isLoading, data, error} = useQuery(
    ["transaction", currentAccount],
    () => getTransactions({
        accountId: currentAccount.value,
        orderBy: 'created_at',
        direction: 'desc',
        limit: 5
    }),
    {
        refetchInterval: 5000,
    }
);

function setCurrentAccount(accountId: number) {
    currentAccount.value = accountId;
}
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <div>
                <nav class="flex space-x-4" aria-label="Tabs">
                    <a v-for="account in accounts" :key="account.name" @click="setCurrentAccount(account.id)"
                       :class="[account.id === currentAccount ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700 cursor-pointer', 'rounded-md px-3 py-2 text-sm font-medium']">{{
                            account.name
                        }} {{ account.balance }}$</a>
                </nav>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <TransactionList :account-id="currentAccount" :data="data?.transactions ?? []" :is-loading="isLoading"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
