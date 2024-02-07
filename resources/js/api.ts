import {Transaction} from "./types";

type Props = {
    accountId: number;
    limit?: number;
    offset?: number;
    query?: string;
    direction?: string;
    orderBy?: string;
}
export const getTransactions = async ({
  accountId,
  limit,
  offset,
  query,
  direction,
  orderBy
}: Props): Promise<{
    transactions: Transaction[];
    total: number;
}> => {
    let url = `/api/accounts/${accountId}/transactions`;
    const params = new URLSearchParams();
    if (limit) {
        params.append('limit', limit.toString());
    }
    if (offset) {
        params.append('offset', offset.toString());
    }
    if (query) {
        params.append('query', query);
    }
    if (direction) {
        params.append('direction', direction);
    }
    if (orderBy) {
        params.append('orderBy', orderBy);
    }
    if (params.toString()) {
        url += `?${params.toString()}`
    }


    return fetch(url).then((response) => response.json())
};
