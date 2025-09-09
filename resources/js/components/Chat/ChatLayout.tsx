export default function ChatLayout({ sidebar, children }) {
    return (
        <div className="chat-layout">
            <aside className="chat-sidebar">{sidebar}</aside>
            <main className="chat-main">{children}</main>
        </div>
    );
}
