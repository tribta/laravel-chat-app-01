import ChatLayout from '@/components/ChatComponent/ChatLayout';
import ConversationList from '@/components/ChatComponent/ConversationList';
import NewConversation from '@/components/ChatComponent/NewConversation';
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
                <p>
                    <i>Choose one person to Create new Conversation.</i>
                </p>
            </ChatLayout>
        </AppLayout>
    );
}
