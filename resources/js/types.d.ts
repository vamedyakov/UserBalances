
export interface Transaction {
    "id": number,
    "account_id": number,
    "amount": string,
    "type": 'deposit' | 'withdraw',
    "description": string
    "created_at": string
    "updated_at": string
}
export interface Account {
    balance: string;
    created_at: string;
    id: number;
    is_default: boolean;
    name: string;
    updated_at: string;
    user_id: number;
}
