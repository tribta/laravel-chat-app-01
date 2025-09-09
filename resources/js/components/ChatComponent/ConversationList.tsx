//@ts-nocheck
import { Link, usePage } from '@inertiajs/react';

export default function ConversationList({ conversations = [] }) {
    const { url } = usePage();
    if (!conversations.length) return <div>No Conversation Found.</div>;

    return (
        <ul>
            {conversations.map((c) => {
                const active = url === `/chat/${c.id}`;

                return (
                    <li key={c.id} className="conv-item">
                        <Link href={`/chat/${c.id}`} className={`conv-link ${active ? 'active' : ''}`}>
                            <div>{c.is_direct === 1 ? 'Direct Message' : c.name || `Group #${c.id}`}</div>
                            {c.last_message && (
                                <div>
                                    {c.last_message.user.name}
                                    <span>: </span>
                                    {c.last_message.body.slice(0, 40) + '...'}
                                </div>
                            )}
                        </Link>
                    </li>
                );
            })}
        </ul>
    );
}
