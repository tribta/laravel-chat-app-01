// @ts-nocheck
import { useEffect, useRef } from 'react';

export default function MessageList({ messages, currentUserId }) {
    const containerRef = useRef(null);

    const bottomRef = useRef(null);

    const isNearBottom = () => {
        const el = containerRef.current;
        if (!el) return true;
        const threshold = 120;
        return el.scrollHeight - el.scrollTop - el.clientHeight < threshold;
    };

    useEffect(() => {
        if (isNearBottom()) bottomRef.current.scrollIntoView({ behavior: 'smooth' });
    }, [messages?.data?.length]);

    useEffect(() => {
        bottomRef.current.scrollIntoView({ behavior: 'auto' });
    }, []);

    return (
        <div ref={containerRef} className="message-list">
            {messages.data.map((m) => {
                const me = currentUserId && m.user?.id === currentUserId;
                return (
                    <div key={m.id} className={`msg-item ${me ? 'me' : 'other'}`}>
                        <div className="msg-meta">
                            {m.user?.name} • {new Date(m.created_at).toLocaleString()}
                        </div>
                        <div className="msg-bubble">{m.body}</div>
                    </div>
                );
            })}
            <div ref={bottomRef} />
        </div>
    );
}
