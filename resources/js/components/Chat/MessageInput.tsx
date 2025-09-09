// @ts-nocheck

import { useForm } from '@inertiajs/react';
import { useRef } from 'react';

export default function MessageInput({ conversationId }) {
    const inputRef = useRef(null);
    const { data, setData, post, processing, reset, clearErrors } = useForm({
        conversation_id: conversationId,
        body: '',
    });

    const submit = (e) => {
        e.preventDefault();

        if (!data.body.trim()) return;

        post('/message', {
            preserveScroll: true,
            preserveState: false,
            onSuccess: () => reset('body'),
            onFinish: () => {
                clearErrors();
                if (data.body !== '') setData('body', '');
                inputRef.current.focus();
            },
        });
    };

    return (
        <form className="mi-form" onSubmit={submit} autoComplete="off">
            <input
                ref={inputRef}
                className="mi-input"
                name="body"
                value={data.body}
                onChange={(e) => setData('body', e.target.value)}
                placeholder="Type a message…"
                autoComplete="new-password"
            />
            <button className="mi-send" type="submit" disabled={processing}>
                Send
            </button>
        </form>
    );
}
