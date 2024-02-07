<script lang="ts">
import {defineComponent, ref, watch} from "vue";
import {Transaction} from "../types";
import {icons, statuses} from "../const";
import {
    ChevronDownIcon,
    ChevronUpIcon
} from '@heroicons/vue/20/solid'

export default defineComponent({
    name: "TransactionTable",
    props: {
        data: Array as () => Transaction[],
        isLoading: Boolean,
        page: {
            type: Number,
            required: true,
        },
        total: {
            type: Number,
            required: true,
        },
        orderBy: {
            type: String,
            required: true,
        },
        direction: {
            type: String,
            required: true,
        },
    },
    methods: {
        formatDateTime(dateTimeString) {
            const dateTime = new Date(dateTimeString);
            return dateTime.toLocaleString();
        },
    },
    emits: ['setSort', 'changeLimit', 'changePage'],
    setup(props, {emit: $emit}) {
        const limit = ref(100);

        watch(limit, (value) => {
            $emit('changeLimit', value);
        });

        return {
            icons,
            statuses,
            ChevronDownIcon,
            ChevronUpIcon,
            limit
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
        <div v-else-if="data && data.length > 0" class="bg-white shadow-sm sm:rounded-lg">
            <div class="flow-root">
                <div class="overflow-x-auto">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="hidden sm:block">
                            <p class="text-sm text-gray-700">
                                Showing
                                {{ ' ' }}
                                <span class="font-medium">{{page*limit - limit+1}}</span>
                                {{ ' ' }}
                                to
                                {{ ' ' }}
                                <span class="font-medium">{{page*limit}}</span>
                                {{ ' ' }}
                                of
                                {{ ' ' }}
                                <span class="font-medium">{{ total }}</span>
                                {{ ' ' }}
                                results
                            </p>
                        </div>
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                    <a href="#" @click="$emit('setSort', 'id')" class="group inline-flex">
                                        ID
                                        <span :class="[orderBy === 'id' ? 'bg-gray-100 text-gray-900 group-hover:bg-gray-200' : 'invisible group-hover:visible group-focus:visible text-gray-400', 'ml-2 flex-none rounded']">
                                            <component :is="direction === 'desc' ? ChevronDownIcon : ChevronUpIcon" class="h-5 w-5" aria-hidden="true" />
                                        </span>
                                    </a>
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    <a href="#" @click="$emit('setSort', 'type')" class="group inline-flex">
                                        Type
                                        <span :class="[orderBy === 'type' ? 'bg-gray-100 text-gray-900 group-hover:bg-gray-200' : 'invisible group-hover:visible group-focus:visible text-gray-400', 'ml-2 flex-none rounded']">
                                            <component :is="direction === 'desc' ? ChevronDownIcon : ChevronUpIcon" class="h-5 w-5" aria-hidden="true" />
                                        </span>
                                    </a>
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    <a href="#" @click="$emit('setSort', 'description')" class="group inline-flex">
                                        Description
                                        <span :class="[orderBy === 'description' ? 'bg-gray-100 text-gray-900 group-hover:bg-gray-200' : 'invisible group-hover:visible group-focus:visible text-gray-400', 'ml-2 flex-none rounded']">
                                            <component :is="direction === 'desc' ? ChevronDownIcon : ChevronUpIcon" class="h-5 w-5" aria-hidden="true" />
                                        </span>
                                    </a>
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    <a href="#" @click="$emit('setSort', 'created_at')" class="group inline-flex">
                                        Created At
                                        <span :class="[orderBy === 'created_at' ? 'bg-gray-100 text-gray-900 group-hover:bg-gray-200' : 'invisible group-hover:visible group-focus:visible text-gray-400', 'ml-2 flex-none rounded']">
                                            <component :is="direction === 'desc' ? ChevronDownIcon : ChevronUpIcon " class="h-5 w-5" aria-hidden="true" />
                                        </span>
                                    </a>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            <tr v-for="item in data" :key="item.id">
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ item.id }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <div class="flex gap-x-3">
                                        <component :is="icons[item.type]" class="hidden h-6 w-5 flex-none text-gray-400 sm:block" aria-hidden="true" />
                                        <div class="flex">
                                            <div :class="[statuses[item.type], 'rounded-md py-1 px-2 text-xs font-medium ring-1 ring-inset']">{{ item.type }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ item.description }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ formatDateTime(item.created_at) }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="flex justify-between items-center">
                            <div>
                                <select v-model="limit" id="location" name="location" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <option value="1">1</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>

                            <div class="flex  justify-between sm:justify-end">
                                <a href="#" v-if="page > 1" @click="$emit('changePage', page-1)" class="relative inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0">Previous</a>
                                <a href="#" v-if="page*limit < total" @click="$emit('changePage', page+1)" class="relative ml-3 inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0">Next</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="text-gray-500 text-center py-4">
            No transaction found
        </div>
    </div>
</template>
