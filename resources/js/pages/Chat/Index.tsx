import ChatLayout from '@/components/Chat/ChatLayout';
import ConversationList from '@/components/Chat/ConversationList';
import NewConversation from '@/components/Chat/NewConversation';
import AppLayout from '@/layouts/app-layout';

export default function Index({ conversations, users }) {
    return (
        <AppLayout>
            <ChatLayout
                sidebar={
                    <>
                        <NewConversation users={users} />
                        <ConversationList conversations={conversations} />
                    </>
                }
            >
                <p>No Message Found.</p>
            </ChatLayout>
        </AppLayout>
    );
}
