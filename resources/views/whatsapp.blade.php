<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Web Dashboard</title>
    <!-- Modern typography -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* WhatsApp Dark Theme Color Palette */
            --bg-app-left: #111b21;
            --bg-app-right: #0b141a;
            --bg-header: #202c33;
            --bg-active-chat: #2a3942;
            --bg-hover-chat: #202c33;
            --border-color: #222d34;
            --text-primary: #e9edef;
            --text-secondary: #8696a0;
            --text-bubble-me: #e9edef;
            --text-bubble-other: #e9edef;
            --bg-bubble-me: #005c4b;
            --bg-bubble-other: #202c33;
            --bg-input: #2a3942;
            --accent-green: #00a884;
            --accent-blue: #53bdeb;
            --accent-yellow: #ffd279;
            --sidebar-width: 64px;
            --chats-panel-width: 340px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: #0b141a;
            color: var(--text-primary);
            height: 100vh;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Root Container for Dashboard */
        .whatsapp-dashboard {
            display: flex;
            width: 100vw;
            height: 100vh;
            background-color: var(--bg-app-left);
            overflow: hidden;
            position: relative;
        }

        /* 1. Thin Leftmost Sidebar (Icon Navigation) */
        .left-icon-sidebar {
            width: var(--sidebar-width);
            background-color: var(--bg-header);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
            z-index: 10;
        }

        .sidebar-icons-top, .sidebar-icons-bottom {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            width: 100%;
        }

        .sidebar-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 10px;
            border-radius: 8px;
            position: relative;
            transition: all 0.2s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 44px;
            height: 44px;
        }

        .sidebar-btn:hover, .sidebar-btn.active {
            color: var(--text-primary);
            background-color: var(--bg-active-chat);
        }

        .sidebar-btn.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 10px;
            bottom: 10px;
            width: 3px;
            background-color: var(--accent-green);
            border-radius: 0 4px 4px 0;
        }

        .badge-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            background-color: var(--accent-green);
            border-radius: 50%;
        }

        .user-avatar-btn img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border-color);
        }

        /* 2. Middle Panel (Chats List Panel) */
        .chats-list-panel {
            width: var(--chats-panel-width);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            background-color: var(--bg-app-left);
            z-index: 5;
        }

        .chats-header {
            padding: 20px 16px 10px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chats-header h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .chats-header-actions {
            display: flex;
            gap: 16px;
        }

        .header-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            transition: color 0.2s;
        }

        .header-btn:hover {
            color: var(--text-primary);
        }

        /* Search & Filters Container */
        .search-filters-container {
            padding: 8px 16px 12px 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .search-bar-wrapper {
            position: relative;
            width: 100%;
        }

        .search-input {
            width: 100%;
            background-color: var(--bg-header);
            border: none;
            border-radius: 8px;
            padding: 8px 12px 8px 40px;
            color: var(--text-primary);
            font-size: 14px;
            outline: none;
            height: 36px;
        }

        .search-input::placeholder {
            color: var(--text-secondary);
        }

        .search-icon-svg {
            position: absolute;
            left: 12px;
            top: 9px;
            color: var(--text-secondary);
            pointer-events: none;
        }

        .tags-container {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            scrollbar-width: none; /* Hide scrollbar for clean UI */
            padding-bottom: 2px;
        }

        .tags-container::-webkit-scrollbar {
            display: none;
        }

        .tag-pill {
            background-color: var(--bg-header);
            color: var(--text-secondary);
            border: none;
            border-radius: 16px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .tag-pill:hover {
            background-color: var(--bg-active-chat);
            color: var(--text-primary);
        }

        .tag-pill.active {
            background-color: #005c4b;
            color: #d1f4cc;
        }

        .tag-add-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background-color: var(--bg-header);
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            flex-shrink: 0;
        }

        .tag-add-btn:hover {
            color: var(--text-primary);
            background-color: var(--bg-active-chat);
        }

        /* Chats List Container */
        .chats-scroll-list {
            flex: 1;
            overflow-y: auto;
            position: relative;
        }

        .chats-scroll-list::-webkit-scrollbar {
            width: 6px;
        }

        .chats-scroll-list::-webkit-scrollbar-thumb {
            background-color: #374248;
            border-radius: 3px;
        }

        .chat-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            cursor: pointer;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.2s;
            position: relative;
        }

        .chat-item:hover {
            background-color: var(--bg-hover-chat);
        }

        .chat-item.active {
            background-color: var(--bg-active-chat);
        }

        .chat-avatar {
            position: relative;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .chat-avatar img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
        }

        .online-dot {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 12px;
            height: 12px;
            background-color: var(--accent-green);
            border: 2px solid var(--bg-app-left);
            border-radius: 50%;
        }

        .chat-info {
            flex: 1;
            min-width: 0; /* Important for text truncation */
        }

        .chat-row-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }

        .chat-name {
            font-weight: 500;
            color: var(--text-primary);
            font-size: 15px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .chat-time {
            font-size: 11px;
            color: var(--text-secondary);
            flex-shrink: 0;
        }

        .chat-row-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-preview {
            font-size: 13px;
            color: var(--text-secondary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding-right: 8px;
        }

        .chat-status-badges {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }

        .unread-badge {
            background-color: var(--accent-green);
            color: #0b141a;
            font-size: 11px;
            font-weight: 700;
            min-width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 4px;
        }

        .mute-icon {
            color: var(--text-secondary);
            display: flex;
            align-items: center;
        }

        /* 3. Right Chat Panel (Active Chat window) */
        .chat-window-panel {
            flex: 1;
            background-color: var(--bg-app-right);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        /* Empty State */
        .chat-window-empty {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background-color: #222e35;
            border-bottom: 6px solid var(--accent-green);
            padding: 20px;
        }

        .empty-illustration {
            margin-bottom: 28px;
            max-width: 320px;
            opacity: 0.85;
        }

        .chat-window-empty h2 {
            font-size: 32px;
            font-weight: 300;
            color: var(--text-primary);
            margin-bottom: 12px;
        }

        .chat-window-empty p {
            font-size: 14px;
            color: var(--text-secondary);
            max-width: 480px;
            line-height: 20px;
            margin-bottom: 24px;
        }

        .encryption-note {
            font-size: 12px;
            color: #667781;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Chat Header */
        .chat-window-header {
            height: 60px;
            background-color: var(--bg-header);
            padding: 0 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            z-index: 5;
        }

        .active-contact-profile {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .active-contact-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 12px;
            object-fit: cover;
        }

        .active-contact-info {
            display: flex;
            flex-direction: column;
        }

        .active-contact-name {
            font-weight: 500;
            color: var(--text-primary);
            font-size: 15px;
        }

        .active-contact-status {
            font-size: 11px;
            color: var(--text-secondary);
        }

        .chat-header-actions-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .chat-header-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            transition: color 0.2s;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .chat-header-btn:hover {
            color: var(--text-primary);
        }

        /* Chat Messages Container */
        .chat-messages-container {
            flex: 1;
            overflow-y: auto;
            padding: 20px 5%;
            background-color: #0b141a;
            /* Authentic WhatsApp Dark Background Wallpaper */
            background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png');
            background-repeat: repeat;
            background-opacity: 0.06;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .chat-messages-container::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages-container::-webkit-scrollbar-thumb {
            background-color: #374248;
            border-radius: 3px;
        }

        /* Message Bubbles */
        .message-bubble-wrapper {
            display: flex;
            width: 100%;
            margin-bottom: 2px;
        }

        .message-bubble-wrapper.me {
            justify-content: flex-end;
        }

        .message-bubble-wrapper.other {
            justify-content: flex-start;
        }

        .message-bubble {
            max-width: 65%;
            padding: 6px 10px 8px 10px;
            border-radius: 8px;
            position: relative;
            box-shadow: 0 1px 0.5px rgba(0,0,0,0.13);
            word-wrap: break-word;
        }

        .message-bubble-wrapper.me .message-bubble {
            background-color: var(--bg-bubble-me);
            color: var(--text-bubble-me);
            border-top-right-radius: 0;
        }

        .message-bubble-wrapper.other .message-bubble {
            background-color: var(--bg-bubble-other);
            color: var(--text-bubble-other);
            border-top-left-radius: 0;
        }

        /* Quoted/Reply View Inside Bubble */
        .quoted-message-box {
            background-color: rgba(0, 0, 0, 0.15);
            border-left: 4px solid var(--accent-green);
            padding: 6px 8px;
            border-radius: 4px;
            margin-bottom: 6px;
            font-size: 12px;
            cursor: pointer;
            border-left-color: var(--accent-yellow);
        }

        .quoted-message-box.me-border {
            border-left-color: var(--accent-green);
        }

        .quoted-sender {
            font-weight: 600;
            color: var(--accent-yellow);
            margin-bottom: 2px;
        }

        .quoted-sender.me-color {
            color: var(--accent-green);
        }

        .quoted-text {
            color: #d1d7db;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .message-text {
            font-size: 14.2px;
            line-height: 19px;
            white-space: pre-wrap;
        }

        .message-meta {
            display: inline-flex;
            align-items: center;
            float: right;
            margin-left: 12px;
            margin-top: 4px;
            font-size: 10px;
            color: var(--text-secondary);
            gap: 3px;
            user-select: none;
        }

        .message-meta-me {
            color: #8696a0e6;
        }

        .double-tick-blue {
            color: var(--accent-blue);
        }

        /* Date Header System */
        .system-date-divider {
            display: flex;
            justify-content: center;
            margin: 12px 0;
            user-select: none;
        }

        .system-date-pill {
            background-color: #182229;
            color: var(--text-secondary);
            font-size: 11px;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 8px;
            text-transform: uppercase;
            box-shadow: 0 1px 0.5px rgba(0,0,0,0.13);
        }

        /* Chat Window Input Footer */
        .chat-window-footer {
            min-height: 60px;
            background-color: var(--bg-header);
            padding: 8px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-top: 1px solid var(--border-color);
            z-index: 5;
        }

        .footer-action-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.2s;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .footer-action-btn:hover {
            color: var(--text-primary);
            background-color: var(--bg-active-chat);
        }

        .footer-input-wrapper {
            flex: 1;
            position: relative;
        }

        .footer-chat-input {
            width: 100%;
            background-color: var(--bg-input);
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            color: var(--text-primary);
            font-size: 15px;
            outline: none;
            min-height: 40px;
            max-height: 120px;
            resize: none;
        }

        .footer-chat-input::placeholder {
            color: var(--text-secondary);
        }

        /* Floating Interactive Simulator Panel (For Demonstration) */
        .simulator-toggle-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background-color: #008069;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 20px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.4);
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 999;
            transition: transform 0.2s;
        }

        .simulator-toggle-btn:hover {
            transform: scale(1.05);
            background-color: #00967b;
        }

        .simulator-panel {
            position: fixed;
            top: 80px;
            right: 24px;
            width: 320px;
            background-color: #1f2c34;
            border: 1px solid #374248;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.5);
            z-index: 998;
            overflow: hidden;
            display: none;
            animation: slideInRight 0.3s ease;
        }

        @keyframes slideInRight {
            from { transform: translateX(110%); }
            to { transform: translateX(0); }
        }

        .simulator-header {
            background-color: #2a3942;
            padding: 14px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #374248;
        }

        .simulator-header h3 {
            font-size: 15px;
            font-weight: 600;
            color: var(--accent-yellow);
        }

        .simulator-close-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 16px;
        }

        .simulator-body {
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .sim-section-title {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .sim-btn {
            width: 100%;
            background-color: #2a3942;
            color: var(--text-primary);
            border: 1px solid #374248;
            border-radius: 8px;
            padding: 10px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-align: left;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sim-btn:hover {
            background-color: #374248;
            border-color: #4f5d64;
        }

        .sim-toggle-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgba(0,0,0,0.15);
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #374248;
        }

        .sim-toggle-label {
            font-size: 13px;
        }

        /* Switch UI component */
        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 22px;
        }

        .switch input { 
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #54656f;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 14px;
            width: 14px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--accent-green);
        }

        input:checked + .slider:before {
            transform: translateX(18px);
        }

        /* Hide scrollbars globally */
        ::-webkit-scrollbar {
            width: 5px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #555;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="whatsapp-dashboard">
        
        <!-- 1. LEFT NAVIGATION SIDEBAR -->
        <aside class="left-icon-sidebar">
            <div class="sidebar-icons-top">
                <button class="sidebar-btn active" title="Chats">
                    <span class="badge-dot"></span>
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12c0 2.2.72 4.23 1.94 5.9L3 21l3.1-1.06C7.77 21.28 9.8 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm0 18c-1.84 0-3.55-.53-5-1.45l-.36-.22-1.88.64.65-1.82-.25-.39C4.24 15.31 3.5 13.23 3.5 12c0-4.69 3.81-8.5 8.5-8.5s8.5 3.81 8.5 8.5-3.81 8.5-8.5 8.5z"/></svg>
                </button>
                <button class="sidebar-btn" title="Calls">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                </button>
                <button class="sidebar-btn" title="Status">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                </button>
                <button class="sidebar-btn" title="Channels">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                </button>
                <button class="sidebar-btn" title="Meta AI" style="color: #a876ff;">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15.5h-2v-2h2v2zm0-4.5h-2v-5h2v5z"/></svg>
                </button>
            </div>
            <div class="sidebar-icons-bottom">
                <button class="sidebar-btn" title="Settings">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                </button>
                <div class="user-avatar-btn" title="Profile">
                    <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80" alt="My Profile">
                </div>
            </div>
        </aside>

        <!-- 2. MIDDLE CHATS LIST PANEL -->
        <section class="chats-list-panel">
            <header class="chats-header">
                <h1>Chats</h1>
                <div class="chats-header-actions">
                    <button class="header-btn" title="New Chat">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                    </button>
                    <button class="header-btn" title="More Options">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                    </button>
                </div>
            </header>

            <div class="search-filters-container">
                <div class="search-bar-wrapper">
                    <svg class="search-icon-svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                    <input type="text" id="chat-search" class="search-input" placeholder="Search or start a new chat">
                </div>
                
                <div class="tags-container">
                    <button class="tag-pill active" onclick="filterChats('all')">All</button>
                    <button class="tag-pill" onclick="filterChats('unread')">Unread</button>
                    <button class="tag-pill" onclick="filterChats('favourites')">Favourites</button>
                    <button class="tag-pill" onclick="filterChats('groups')">Groups</button>
                    <button class="tag-add-btn" title="Add Filter">+</button>
                </div>
            </div>

            <!-- Contacts list -->
            <div class="chats-scroll-list" id="chats-list">
                <!-- Chat Items will be rendered dynamically by JavaScript -->
            </div>
        </section>

        <!-- 3. RIGHT CHAT WINDOW PANEL -->
        <main class="chat-window-panel">
            
            <!-- Welcome Empty State -->
            <div class="chat-window-empty" id="chat-welcome-state">
                <img class="empty-illustration" src="https://images.unsplash.com/photo-1614741118887-7a4ee193a5fa?w=400&auto=format&fit=crop&q=60" style="border-radius: 12px; filter: grayscale(40%)" alt="Dashboard Active">
                <h2>WhatsApp Web Clone</h2>
                <p>Send and receive messages in real time. Connect with developer tools to test integrations instantly. Select a chat from the left side panel to start messaging.</p>
                <div class="encryption-note">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                    <span>Developer Dashboard - End-to-end simulated active connection</span>
                </div>
            </div>

            <!-- Active Chat State (Hidden by default) -->
            <div id="chat-active-state" style="display: none; flex-direction: column; height: 100%;">
                
                <!-- Chat Window Header -->
                <header class="chat-window-header">
                    <div class="active-contact-profile">
                        <img id="active-chat-avatar" class="active-contact-avatar" src="" alt="">
                        <div class="active-contact-info">
                            <span id="active-chat-name" class="active-contact-name"></span>
                            <span id="active-chat-status" class="active-contact-status">online</span>
                        </div>
                    </div>
                    <div class="chat-header-actions-right">
                        <button class="chat-header-btn" title="Video Call">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>
                        </button>
                        <button class="chat-header-btn" title="Voice Call">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 0 0-1.01.24l-2.2 2.2a15.045 15.045 0 0 1-6.59-6.59l2.2-2.21a.96.96 0 0 0 .25-1.02c-.36-1.11-.56-2.3-.56-3.53C8.38 3.45 7.93 3 7.38 3H4.01C3.46 3 3 3.45 3 4c0 9.39 7.62 17.01 17 17.01.55 0 1-.45 1-1.01V16.4c0-.55-.45-1.02-.99-1.02z"/></svg>
                        </button>
                        <button class="chat-header-btn" title="Search Message">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                        </button>
                        <button class="chat-header-btn" title="Menu">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                        </button>
                    </div>
                </header>

                <!-- Messages area -->
                <div class="chat-messages-container" id="messages-log">
                    <!-- Messages will be injected dynamically -->
                </div>

                <!-- Chat Footer Input -->
                <footer class="chat-window-footer">
                    <button class="footer-action-btn" title="Emojis">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 6 15.5 6 14 6.67 14 7.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 6 8.5 6 7 6.67 7 7.5 7.67 9 8.5 9zm3.5 5.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/></svg>
                    </button>
                    <button class="footer-action-btn" title="Attach">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                    </button>
                    
                    <div class="footer-input-wrapper">
                        <textarea id="chat-input" class="footer-chat-input" rows="1" placeholder="Type a message" onkeydown="handleInputKey(event)"></textarea>
                    </div>

                    <button class="footer-action-btn" id="send-msg-btn" onclick="sendUserMessage()" title="Send Message">
                        <!-- Microphone Icon default, changes to Send when typing -->
                        <svg id="mic-icon" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3zm5.3-3c0 3-2.54 5.1-5.3 5.1S6.7 14 6.7 11H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c3.28-.48 6-3.3 6-6.72h-1.7z"/></svg>
                        <svg id="send-icon" viewBox="0 0 24 24" width="24" height="24" fill="currentColor" style="display:none; color: var(--accent-green);"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                    </button>
                </footer>

            </div>

        </main>

        <!-- FLOATING SIMULATOR DRAWER (Demonstrates Real-time Actions) -->
        <button class="simulator-toggle-btn" onclick="toggleSimulator()">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg>
            <span>Live Chat Simulator</span>
        </button>

        <div class="simulator-panel" id="simulator-drawer">
            <div class="simulator-header">
                <h3>Live Chat Simulator</h3>
                <button class="simulator-close-btn" onclick="toggleSimulator()">&times;</button>
            </div>
            <div class="simulator-body">
                <div>
                    <span class="sim-section-title">Automation Settings</span>
                    <div class="sim-toggle-row">
                        <span class="sim-toggle-label">Auto-Reply (Hinglish Bot)</span>
                        <label class="switch">
                            <input type="checkbox" id="auto-reply-toggle" checked>
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>

                <div>
                    <span class="sim-section-title">Manual Actions</span>
                    <button class="sim-btn" onclick="triggerIncomingMockMessage('Mintu')">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm8 5H6v-2h8v2zm4-6H6V6h12v2z"/></svg>
                        <span>Message from Mintu 🙋‍♂️</span>
                    </button>
                    <button class="sim-btn" style="margin-top: 8px;" onclick="triggerIncomingMockMessage('Airtel')">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm8 5H6v-2h8v2zm4-6H6V6h12v2z"/></svg>
                        <span>Promo from Airtel 🔴</span>
                    </button>
                    <button class="sim-btn" style="margin-top: 8px;" onclick="triggerIncomingMockMessage('Biraj')">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm8 5H6v-2h8v2zm4-6H6V6h12v2z"/></svg>
                        <span>YouTube Link from Biraj 🎥</span>
                    </button>
                </div>

                <div style="background-color: rgba(255,210,121,0.05); padding: 12px; border-radius: 8px; border: 1px dashed rgba(255,210,121,0.3);">
                    <p style="font-size: 12px; color: var(--accent-yellow); line-height: 16px;">
                        <strong>Simulator Information:</strong><br>
                        Turn on auto-reply to make contacts automatically reply to your messages instantly! Perfect for demonstrating live-chat interaction without databases.
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- Audio chime on new message -->
    <audio id="incoming-sound" src="https://assets.mixkit.co/active_storage/sfx/2357/2357-84.wav" preload="auto"></audio>

    <script>
        // Mock DB Data Structure
        let chatsData = [
            {
                id: 1,
                name: 'Mintu 😃😃😃',
                avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80',
                time: '9:10 am',
                preview: 'Wait',
                unread: 1,
                status: 'online',
                isGroup: false,
                isFav: true,
                messages: [
                    { sender: 'them', text: 'Are isme whatsapp ka dashboard kaha hain isme chats kaise dikhega', time: '8:27 am' },
                    { sender: 'them', text: '???', time: '8:27 am' },
                    { sender: 'me', quoteSender: 'Mintu 😃😃😃', quoteText: 'Are isme whatsapp ka dashboard kaha hain isme chats kaise dikhega', text: 'Udhar qr scan karene se apka wp conect hoga', time: '8:28 am', status: 'read' },
                    { sender: 'me', text: 'Or live chats bale option main dikhega', time: '8:28 am', status: 'read' },
                    { sender: 'them', text: 'Show me', time: '8:29 am' },
                    { sender: 'me', text: 'Nind se nahi utha main avitk', time: '8:29 am', status: 'read' },
                    { sender: 'them', text: 'Okay baadme dikhao', time: '8:29 am' },
                    { sender: 'me', text: 'Ha', time: '8:30 am', status: 'read' },
                    { sender: 'me', text: 'chacha apko koni functionalityes chiye dashboard main?', time: '8:58 am', status: 'read' },
                    { sender: 'them', text: 'Wait', time: '9:10 am' }
                ]
            },
            {
                id: 2,
                name: 'Airtel',
                avatar: 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=100&auto=format&fit=crop&q=80',
                time: '7:15 am',
                preview: '📺 Hi, your Airtel DTH pack 30638820...',
                unread: 0,
                status: 'offline',
                isGroup: false,
                isFav: false,
                messages: [
                    { sender: 'them', text: '📺 Hi, your Airtel DTH pack 30638820 has expired. Recharge now with ₹350 to continue enjoying your services without interruption.', time: '7:15 am' }
                ]
            },
            {
                id: 3,
                name: 'Biraj',
                avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80',
                time: 'Yesterday',
                preview: 'https://youtu.be/31YzGkSQjHq?si=toO...',
                unread: 0,
                status: 'offline',
                isGroup: false,
                isFav: true,
                messages: [
                    { sender: 'them', text: 'Hey bro, check out this dynamic dashboard overview video:', time: 'Yesterday' },
                    { sender: 'them', text: 'https://youtu.be/31YzGkSQjHq?si=toOqH7vS3', time: 'Yesterday' }
                ]
            },
            {
                id: 4,
                name: 'Porti 🌸🌸',
                avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&auto=format&fit=crop&q=80',
                time: 'Yesterday',
                preview: 'Asa',
                unread: 0,
                status: 'offline',
                isGroup: false,
                isFav: false,
                isMuted: true,
                messages: [
                    { sender: 'me', text: 'Rong ekhon pathate parbi?', time: 'Yesterday', status: 'read' },
                    { sender: 'them', text: 'Asa', time: 'Yesterday' }
                ]
            },
            {
                id: 5,
                name: 'Subhajit Kundu',
                avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80',
                time: 'Yesterday',
                preview: '😊amio ar hope dekhte pcchi na',
                unread: 0,
                status: 'offline',
                isGroup: false,
                isFav: false,
                messages: [
                    { sender: 'them', text: 'bhai, exam kemon holo?', time: 'Yesterday' },
                    { sender: 'me', text: 'khub baje obostha re, pass korte parle bachi', time: 'Yesterday', status: 'read' },
                    { sender: 'them', text: '😊amio ar hope dekhte pcchi na', time: 'Yesterday' }
                ]
            },
            {
                id: 6,
                name: '+91 93302 58194',
                avatar: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=100&auto=format&fit=crop&q=80',
                time: 'Yesterday',
                preview: 'Java te apply korte paris',
                unread: 0,
                status: 'offline',
                isGroup: false,
                isFav: false,
                messages: [
                    { sender: 'them', text: 'Ekta job vacancy ache core java developement e, apply korte paris.', time: 'Yesterday' }
                ]
            }
        ];

        let activeChatId = null;
        let selectedFilter = 'all';

        // Bot pool replies (Hinglish)
        const botReplies = [
            "Haan bhai! Bol, kaisa lag raha hai dashboard?",
            "Arey bilkul perfect clone hai! Ye live simulation dynamic lag raha hai na?",
            "Mast code banaya hai, pure CSS layout and modern fonts use kiya hai.",
            "Database aur WebSocket connect hone par ye real live messages fetch karega.",
            "Chalo baadme baat karte hain, abhi main code verify kar raha hoon.",
            "Bahut badiya! Aur kya custom features chahiye isme?",
            "Bhai, project ready hai! GitHub me commit karke push kar sakte ho ab."
        ];

        // 1. Initial Load
        window.addEventListener('DOMContentLoaded', () => {
            renderChatsList();
            
            // Search filter listener
            document.getElementById('chat-search').addEventListener('input', (e) => {
                renderChatsList(e.target.value);
            });

            // Handle Dynamic send icon switch on input
            const input = document.getElementById('chat-input');
            if (input) {
                input.addEventListener('input', () => {
                    const mic = document.getElementById('mic-icon');
                    const send = document.getElementById('send-icon');
                    if (input.value.trim() !== "") {
                        mic.style.display = "none";
                        send.style.display = "block";
                    } else {
                        mic.style.display = "block";
                        send.style.display = "none";
                    }
                });
            }
        });

        // 2. Render Left Sidebar Chats
        function renderChatsList(searchTerm = '') {
            const listContainer = document.getElementById('chats-list');
            listContainer.innerHTML = '';

            let filtered = chatsData;

            // Apply tags filter
            if (selectedFilter === 'unread') {
                filtered = filtered.filter(c => c.unread > 0);
            } else if (selectedFilter === 'favourites') {
                filtered = filtered.filter(c => c.isFav);
            } else if (selectedFilter === 'groups') {
                filtered = filtered.filter(c => c.isGroup);
            }

            // Apply search term filter
            if (searchTerm.trim() !== '') {
                filtered = filtered.filter(c => c.name.toLowerCase().includes(searchTerm.toLowerCase()) || c.preview.toLowerCase().includes(searchTerm.toLowerCase()));
            }

            filtered.forEach(chat => {
                const isActive = chat.id === activeChatId ? 'active' : '';
                const unreadBadge = chat.unread > 0 ? `<div class="unread-badge">${chat.unread}</div>` : '';
                const onlineDot = chat.status === 'online' ? `<div class="online-dot"></div>` : '';
                const muteIcon = chat.isMuted ? `
                    <span class="mute-icon">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.21.05-.42.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51C20.63 14.91 21 13.5 21 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71zM4.27 3L3 4.27 7.73 9H3v6h4l5 5v-6.73l4.25 4.25c-.67.52-1.42.93-2.25 1.18v2.06c1.38-.31 2.63-.95 3.69-1.81L19.73 21 21 19.73l-9-9L4.27 3zM12 4L9.91 6.09 12 8.18V4z"/></svg>
                    </span>` : '';

                // Build HTML
                const chatHtml = `
                    <div class="chat-item ${isActive}" onclick="selectChat(${chat.id})">
                        <div class="chat-avatar">
                            <img src="${chat.avatar}" alt="${chat.name}">
                            ${onlineDot}
                        </div>
                        <div class="chat-info">
                            <div class="chat-row-top">
                                <span class="chat-name">${chat.name}</span>
                                <span class="chat-time">${chat.time}</span>
                            </div>
                            <div class="chat-row-bottom">
                                <span class="chat-preview">${chat.preview}</span>
                                <div class="chat-status-badges">
                                    ${muteIcon}
                                    ${unreadBadge}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                listContainer.insertAdjacentHTML('beforeend', chatHtml);
            });
        }

        // 3. Filter Tag Switcher
        function filterChats(filterType) {
            selectedFilter = filterType;
            
            // Toggle active visual states on pills
            document.querySelectorAll('.tag-pill').forEach(pill => {
                pill.classList.remove('active');
                if (pill.textContent.toLowerCase() === filterType) {
                    pill.classList.add('active');
                }
            });

            renderChatsList();
        }

        // 4. Select a Active Chat
        function selectChat(chatId) {
            activeChatId = chatId;
            
            // Find chat in array
            const chat = chatsData.find(c => c.id === chatId);
            if (!chat) return;

            // Reset unread count
            chat.unread = 0;

            // Show active panel, hide welcome screen
            document.getElementById('chat-welcome-state').style.display = 'none';
            document.getElementById('chat-active-state').style.display = 'flex';

            // Populate header
            document.getElementById('active-chat-avatar').src = chat.avatar;
            document.getElementById('active-chat-name').textContent = chat.name;
            document.getElementById('active-chat-status').textContent = chat.status;
            
            // Re-render chat list to clear unread badge
            renderChatsList();

            // Load and render message logs
            renderMessages();
        }

        // 5. Render Messages inside Active Chat
        function renderMessages() {
            const messageLog = document.getElementById('messages-log');
            messageLog.innerHTML = '';

            const chat = chatsData.find(c => c.id === activeChatId);
            if (!chat) return;

            // Add an initial Date Header for realism
            messageLog.insertAdjacentHTML('beforeend', `
                <div class="system-date-divider">
                    <span class="system-date-pill">TODAY</span>
                </div>
            `);

            chat.messages.forEach(msg => {
                const isMe = msg.sender === 'me';
                const wrapperClass = isMe ? 'me' : 'other';
                
                // Double tick markup
                const doubleTick = isMe ? `
                    <svg class="double-tick-blue" viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M0.293 12.293a1 1 0 0 1 1.414 0L7 17.586 19.293 5.293a1 1 0 1 1 1.414 1.414l-13 13a1 1 0 0 1-1.414 0l-6-6a1 1 0 0 1 0-1.414zM12 17.586l6.293-6.293a1 1 0 1 1 1.414 1.414l-7 7a1 1 0 0 1-1.414 0l-2-2a1 1 0 1 1 1.414-1.414L12 17.586z"/></svg>` : '';

                // Handle quote reply box markup
                let quoteMarkup = '';
                if (msg.quoteText) {
                    const isQuoteMe = msg.quoteSender === 'You';
                    quoteMarkup = `
                        <div class="quoted-message-box ${isQuoteMe ? 'me-border' : ''}">
                            <div class="quoted-sender ${isQuoteMe ? 'me-color' : ''}">${msg.quoteSender}</div>
                            <div class="quoted-text">${msg.quoteText}</div>
                        </div>
                    `;
                }

                const msgHtml = `
                    <div class="message-bubble-wrapper ${wrapperClass}">
                        <div class="message-bubble">
                            ${quoteMarkup}
                            <div class="message-text">${msg.text}</div>
                            <span class="message-meta ${isMe ? 'message-meta-me' : ''}">
                                <span>${msg.time}</span>
                                ${doubleTick}
                            </span>
                        </div>
                    </div>
                `;
                messageLog.insertAdjacentHTML('beforeend', msgHtml);
            });

            // Scroll to bottom
            scrollToBottom();
        }

        // 6. Handle Input Keys (Enter to send)
        function handleInputKey(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendUserMessage();
            }
        }

        // 7. Send Message
        function sendUserMessage() {
            const input = document.getElementById('chat-input');
            const messageText = input.value.trim();
            if (messageText === '' || activeChatId === null) return;

            const chat = chatsData.find(c => c.id === activeChatId);
            if (!chat) return;

            const now = new Date();
            const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }).toLowerCase();

            // Insert into active chats message list
            const newMessage = {
                sender: 'me',
                text: messageText,
                time: timeStr,
                status: 'read'
            };

            // If user double-clicks or replies, we could quote, for simplicity, we append regular
            chat.messages.push(newMessage);
            chat.preview = messageText;
            chat.time = timeStr;

            // Clear input & refresh UI
            input.value = '';
            
            // Trigger input styling switch back to microphone
            document.getElementById('mic-icon').style.display = "block";
            document.getElementById('send-icon').style.display = "none";

            renderMessages();
            renderChatsList();

            // Trigger Bot Auto Reply if turned on
            const autoReply = document.getElementById('auto-reply-toggle').checked;
            if (autoReply) {
                // Simulate active typing indicators
                document.getElementById('active-chat-status').textContent = 'typing...';
                
                setTimeout(() => {
                    triggerBotReply(chat);
                }, 1500);
            }
        }

        // 8. Trigger Bot Auto-Reply (Simulation)
        function triggerBotReply(chat) {
            if (activeChatId === chat.id) {
                document.getElementById('active-chat-status').textContent = 'online';
            }

            const now = new Date();
            const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }).toLowerCase();
            
            // Random hinglish message selection
            const randomReply = botReplies[Math.floor(Math.random() * botReplies.length)];

            chat.messages.push({
                sender: 'them',
                text: randomReply,
                time: timeStr
            });
            chat.preview = randomReply;
            chat.time = timeStr;

            // Play sound
            playNotificationSound();

            if (activeChatId === chat.id) {
                renderMessages();
            } else {
                chat.unread += 1;
            }
            renderChatsList();
        }

        // 9. Play incoming chime sound
        function playNotificationSound() {
            const sound = document.getElementById('incoming-sound');
            if (sound) {
                sound.currentTime = 0;
                sound.play().catch(e => console.log('Audio playback blocked by browser policies.'));
            }
        }

        // 10. Scroll Active Chat Area to bottom
        function scrollToBottom() {
            const messageLog = document.getElementById('messages-log');
            messageLog.scrollTop = messageLog.scrollHeight;
        }

        // 11. Toggle Simulator Drawer UI
        function toggleSimulator() {
            const drawer = document.getElementById('simulator-drawer');
            if (drawer.style.display === 'none' || drawer.style.display === '') {
                drawer.style.display = 'block';
            } else {
                drawer.style.display = 'none';
            }
        }

        // 12. Trigger Manual Mock Message from Simulator
        function triggerIncomingMockMessage(contactKey) {
            let targetChat = chatsData.find(c => c.name.includes(contactKey));
            if (!targetChat) return;

            const now = new Date();
            const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }).toLowerCase();

            let mockText = "Oi bro, kahan ho?";
            if (contactKey === 'Airtel') {
                mockText = "🎁 Special Offer: Unlimited Calling + 2GB data daily at ₹299 only! Recharge now.";
            } else if (contactKey === 'Biraj') {
                mockText = "Bhai, check this repository push status: git push -u origin main!";
            } else if (contactKey === 'Mintu') {
                mockText = "Wait, main scan complete karta hoon local system ka.";
            }

            targetChat.messages.push({
                sender: 'them',
                text: mockText,
                time: timeStr
            });
            targetChat.preview = mockText;
            targetChat.time = timeStr;

            playNotificationSound();

            if (activeChatId === targetChat.id) {
                renderMessages();
            } else {
                targetChat.unread += 1;
            }

            renderChatsList();
        }
    </script>
</body>
</html>
