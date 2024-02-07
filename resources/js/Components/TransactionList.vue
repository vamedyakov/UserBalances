<script lang="ts">
import {defineComponent} from "vue";
import {Transaction} from "../types";
import {icons, statuses} from "../const";

export default defineComponent({
    name: "TransactionList",
    props: {
        accountId: {
            type: Number,
            required: true,
        },
        data: Array as () => Transaction[],
        isLoading: Boolean,
    },
    methods: {
        formatDateTime(dateTimeString) {
            const dateTime = new Date(dateTimeString);
            return dateTime.toLocaleString();
        },
    },
    setup(props) {
        return {
            icons,
            statuses,
        }
    }
});
</script>

<template>
    <div>
        <div v-if="isLoading">
            <div class="animate-pulse">
                <div class="bg-gray-200 h-4 rounded mb-2"></div>
                <div class="bg-gray-200 h-4 rounded mb-2 w-3/4"></div>
                <div class="bg-gray-200 h-4 rounded mb-2 w-1/2"></div>
            </div>
        </div>
        <div v-else-if="data && data.length > 0" class="bg-white shadow-sm sm:rounded-lg py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                <h2 class="text-base font-semibold leading-6 text-gray-900">Recent activity</h2>

                <a :href="`/history/${accountId}`" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Show more
                </a>
            </div>
            <div class="mt-6 overflow-hidden border-t border-gray-100">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                        <table class="w-full text-left">
                            <tbody>
                                <tr v-for="item in data" :key="item.id">
                                    <td class="relative py-5 pr-6">
                                        <div class="flex gap-x-6">
                                            <component :is="icons[item.type]" class="hidden h-6 w-5 flex-none text-gray-400 sm:block" aria-hidden="true" />
                                            <div class="flex-auto">
                                                <div class="flex items-start gap-x-3">
                                                    <div class="text-sm font-medium leading-6 text-gray-900">{{ item.amount }}</div>
                                                    <div :class="[statuses[item.type], 'rounded-md py-1 px-2 text-xs font-medium ring-1 ring-inset']">{{ item.type }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="absolute bottom-0 right-full h-px w-screen bg-gray-100" />
                                        <div class="absolute bottom-0 left-0 h-px w-screen bg-gray-100" />
                                    </td>
                                    <td class="hidden py-5 pr-6 sm:table-cell">
                                        <div class="mt-1 text-xs leading-5 text-gray-500">{{ item.description }}</div>
                                    </td>
                                    <td class="py-5 text-right">
                                        <div class="mt-1 text-xs leading-5 text-gray-500">
                                            Invoice <span class="text-gray-900">#{{ item.id }}</span>
                                        </div>
                                        <div class="mt-1 text-xs leading-5 text-gray-500">
                                            {{ formatDateTime(item.created_at) }}
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="text-gray-500 text-center py-4">
            No transaction found
        </div>
    </div>
</template>
