// @ts-nocheck
import { router, useForm } from '@inertiajs/react';
import { useState } from 'react';

export default function NewConversation({ users = [] }) {
    const [groupName, setGroupName] = useState('');
    const { data, setData, reset, errors } = useForm({
        user_ids: [],
        name: undefined,
    });
    const [busy, setBusy] = useState(false);

    const toggle = (id) => {
        setData('user_ids', data.user_ids.includes(id) ? data.user_ids.filter((x) => x !== id) : [...data.user_ids, id]);
    };

    const submit = (e) => {
        e.preventDefault();
        const payload = {
            user_ids: data.user_ids,
            name: data.user_ids.length >= 2 ? groupName || undefined : undefined,
        };
        if (!payload.user_ids.length) return;

        router.post('/chat', payload, {
            onStart: () => setBusy(true),
            onFinish: () => setBusy(false),
            onSuccess: () => {
                reset();
                setGroupName('');
            },
        });
    };

    return (
        <form onSubmit={submit} className="nc-form">
            <div className="nc-title">Create New Conversation</div>
            {data.user_ids.length >= 2 && (
                <input
                    className="nc-groupname"
                    value={groupName}
                    onChange={(e) => setGroupName(e.target.value)}
                    placeholder="Enter Your GroupName (optional)"
                />
            )}

            <div className="nc-list">
                {users.map((u) => (
                    <label key={u.id} className="nc-item">
                        <input type="checkbox" checked={data.user_ids.includes(u.id)} onChange={() => toggle(u.id)} />
                        <div>
                            <div className="nc-name">{u.name}</div>
                            <div className="nc-email">{u.email}</div>
                        </div>
                    </label>
                ))}
            </div>

            {errors.user_ids && <div className="nc-error">{String(errors.user_ids)}</div>}
            {errors.name && <div className="nc-error">{String(errors.name)}</div>}

            <button 
                className='nc-submit' 
                type='submit' 
                disabled={busy || data.user_ids.length === 0}
            >
                {busy ? 'Creating...' : 'Create'}
            </button>
        </form>
    );
}
