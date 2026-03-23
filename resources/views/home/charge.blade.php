<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Red Panda POS System</title>
    <!-- Icon placeholder -->
    <link href="{{ asset('images/logo.png') }}" rel="icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @push('styles')
    <style>
        /* Base Styles and Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            /* Modern system font stack */
            font-family: 'system-ui', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        :root {
            --primary-color: #D94E33; /* Red-Orange */
            --secondary-color: #7A6158; /* Muted Brown-Purple */
            --accent-color: #4C956C; /* Green (currently unused) */
            --light-color: #F8F9FA; /* Lighter background/border */
            --dark-color: #343A40; /* Dark text */
            --danger-color: #DC3545; /* Red for errors/discounts */
            --success-color: #28A745; /* Green for success */
            --warning-color: #FFC107; /* Yellow for warnings */
            --border-radius: 6px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); /* Softer shadow */
            --transition: all 0.3s ease;
            --spacing-unit: 1rem; /* Base spacing */
        }

        body {
            background-color: var(--light-color); /* Use light color variable */
            color: var(--dark-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Bar - Keep largely the same, good contrast */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            padding: 0 var(--spacing-unit) calc(var(--spacing-unit) / 2); /* Adjusted padding */
            min-height: 64px; /* Ensure minimum height */
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid #eee;
        }
        .topbar-left {
            display: flex;
            align-items: center;
            gap: calc(var(--spacing-unit) / 2);
        }
        .topbar-logo {
            width: 32px; /* Slightly smaller */
            height: 32px; /* Slightly smaller */
            border-radius: 4px; /* Slightly smaller radius */
        }
        .topbar-title {
            font-size: 1.2rem; /* Slightly smaller */
            font-weight: 600; /* Slightly lighter weight */
            color: var(--primary-color);
            letter-spacing: 0.5px; /* Less letter spacing */
        }
        .topbar-center {
            display: flex;
            align-items: center;
            gap: var(--spacing-unit);
            font-size: 0.95rem; /* Slightly smaller font */
            color: var(--secondary-color);
        }
        .topbar-date {
            font-weight: 500;
        }
        .topbar-time {
            font-family: monospace;
            font-size: 1rem;
            background: #eee; /* Use a specific light background */
            padding: 2px 8px; /* Adjusted padding */
            border-radius: 4px; /* Adjusted radius */
            margin-left: 4px;
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: calc(var(--spacing-unit) / 2);
        }
        .topbar-user {
            font-weight: 500;
            color: var(--secondary-color);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--primary-color);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1rem;
            margin-right: 4px;
            overflow: hidden;
        }
        
        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .user-info {
            display: flex;
            flex-direction: column;
        }
        .user-name {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.9rem;
        }
        .user-role {
            font-size: 0.8rem;
            color: var(--secondary-color);
            text-transform: capitalize;
        }
        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, #c0392b 100%);
            color: white;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(217, 78, 51, 0.2);
        }
        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(217, 78, 51, 0.3);
            background: linear-gradient(135deg, #c0392b 0%, var(--primary-color) 100%);
        }
        .btn-logout i {
            font-size: 1.1rem;
        }
        @media (max-width: 768px) {
            .topbar {
                flex-direction: column;
                align-items: flex-start;
                height: auto;
                padding: calc(var(--spacing-unit) / 2) var(--spacing-unit); /* Adjusted padding */
                gap: calc(var(--spacing-unit) / 3);
            }
            .topbar-left, .topbar-center, .topbar-right {
                gap: calc(var(--spacing-unit) / 2);
            }
            .topbar-logo, .avatar {
                width: 28px;
                height: 28px;
            }
            .avatar {
                 font-size: 0.9rem;
            }
             .topbar-title {
                font-size: 1.1rem;
            }
            .topbar-center {
                font-size: 0.9rem;
            }
            .topbar-right {
                width: 100%;
                justify-content: space-between;
                margin-top: 8px;
            }
        }


        /* Main Container Layout */
        .main-container {
            display: flex;
            flex: 1; /* Allow main container to grow */
            padding: var(--spacing-unit);
            gap: var(--spacing-unit);
            /* Removed max-height */
        }

        /* Cart Panel */
        .cart-panel {
            flex: 3;
            background-color: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            display: flex;
            flex-direction: column;
            overflow: hidden; /* Contains child overflows */
        }

        /* Payment Panel */
        .payment-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: var(--spacing-unit);
            min-width: 300px;
            max-width: 400px; /* Add max-width for large screens */
        }

        /* Search Bar */
        .search-bar {
            padding: var(--spacing-unit);
            background-color: var(--light-color);
            border-bottom: 1px solid #eee;
        }

        .search-input {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-input input {
            flex: 1;
            padding: 0.75rem var(--spacing-unit);
            border: 1px solid #ccc; /* Slightly softer border */
            border-radius: var(--border-radius);
            font-size: 1rem;
            width: 100%;
            transition: var(--transition);
        }

        .search-input input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(217, 78, 51, 0.2);
        }

        .search-btn {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            color: #888; /* Slightly lighter icon color */
            cursor: pointer;
            font-size: 1.1rem;
        }

        /* Quick Add Categories */
        .quick-add {
            padding: calc(var(--spacing-unit) / 2) var(--spacing-unit); /* Adjusted padding */
            background-color: var(--light-color);
            display: flex;
            overflow-x: auto;
            gap: calc(var(--spacing-unit) / 2);
            scrollbar-width: thin;
             border-bottom: 1px solid #eee; /* Add border bottom */
        }

        .quick-add::-webkit-scrollbar {
            height: 4px;
        }

        .quick-add::-webkit-scrollbar-thumb {
            background-color: var(--secondary-color);
            border-radius: 4px;
        }
         .quick-add::-webkit-scrollbar-track {
            background-color: #eee;
        }


        .quick-item {
            padding: calc(var(--spacing-unit) / 2) var(--spacing-unit); /* Adjusted padding */
            background-color: white;
            border-radius: var(--border-radius);
            cursor: pointer;
            white-space: nowrap;
            border: 1px solid #ddd; /* Softer border */
            transition: var(--transition);
             font-size: 0.9rem;
        }

        .quick-item:hover {
            background-color: var(--primary-color);
            color: white;
             border-color: var(--primary-color);
        }

        /* Quick category active state */
        .quick-item.active {
            background-color: var(--primary-color);
            color: white;
             border-color: var(--primary-color);
        }

        /* Cart Items */
        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 0 var(--spacing-unit);
            background: #fff;
        }

        .cart-header {
            display: grid;
            grid-template-columns: 3fr 1fr 1fr 1fr 1fr 40px;
            padding: var(--spacing-unit) 0; /* Adjusted padding */
            font-weight: 600; /* Slightly lighter weight */
            border-bottom: 1px solid #eee;
            color: var(--secondary-color);
            position: sticky;
            top: 0;
            background: white;
            z-index: 10;
            font-size: 0.9rem;
        }

        .cart-row {
            display: grid;
            grid-template-columns: 3fr 1fr 1fr 1fr 1fr 40px;
            padding: var(--spacing-unit) 0; /* Increased padding for more space */
            align-items: center;
            border-bottom: 1px solid #eee;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: var(--spacing-unit);
        }

        .product-image {
            width: 40px;
            height: 40px;
            background-color: #eee; /* Lighter background */
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: var(--primary-color);
             flex-shrink: 0; /* Prevent shrinking */
        }

        .product-name {
            font-weight: 500;
            margin-bottom: 4px; /* Space between name and code */
        }

        .product-code {
            font-size: 0.8rem;
            color: #777;
        }

        .cart-quantity {
            display: flex;
            align-items: center;
            gap: calc(var(--spacing-unit) / 3); /* Smaller gap */
            font-size: 0.95rem;
        }

        .qty-btn {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ff7e5f 0%, #feb47b 100%);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(.4,0,.2,1);
            font-size: 1.2rem;
            color: #fff;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(255, 126, 95, 0.10);
            margin: 0 2px;
            outline: none;
        }
        .qty-btn:hover, .qty-btn:focus {
            background: linear-gradient(135deg, #feb47b 0%, #ff7e5f 100%);
            box-shadow: 0 4px 16px rgba(255, 126, 95, 0.18);
            transform: translateY(-2px) scale(1.08);
        }
        .qty-btn:active {
            background: linear-gradient(135deg, #ff7e5f 0%, #feb47b 100%);
            box-shadow: 0 1px 4px rgba(255, 126, 95, 0.10);
            transform: scale(0.96);
        }

        .qty-value {
            min-width: 30px;
            text-align: center;
            font-weight: 500;
             padding: 0.2rem 0.4rem; /* Add padding */
             border: 1px solid #ccc; /* Add border */
             border-radius: 4px; /* Match button radius */
             background-color: #fff; /* White background for value */
        }

        .cart-price, .cart-total {
             font-size: 0.95rem;
        }

        .cart-action {
            color: var(--danger-color);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            justify-content: center;
            font-size: 1.1rem; /* Slightly larger icon */
        }

        .cart-action:hover {
            color: #b02a37; /* Darker danger on hover */
            transform: scale(1.1); /* Slightly less dramatic scale */
        }

        /* Summary Card & Payment Card */
        .summary-card, .payment-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            display: flex; /* Make card a flex container */
            flex-direction: column; /* Stack contents vertically */
        }

        .card-title {
            padding: var(--spacing-unit);
            background-color: var(--secondary-color);
            color: white;
            font-weight: 500;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.1rem;
        }

        .card-content { /* Wrapper for content below title */
             padding: var(--spacing-unit);
             display: flex;
             flex-direction: column;
             gap: var(--spacing-unit); /* Spacing between rows/sections */
        }


        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: calc(var(--spacing-unit) / 4) 0; /* Less padding within rows */
            border-bottom: 1px solid #eee;
             font-size: 0.95rem;
        }

        .summary-row:last-child {
             border-bottom: none; /* Remove border on last row */
             padding-bottom: 0;
        }

        .discount-row {
            color: var(--danger-color);
            font-weight: 500;
        }

        .grand-total {
            font-weight: bold;
            font-size: 1.25rem; /* Slightly larger */
            background-color: var(--light-color);
            margin: var(--spacing-unit) calc(-1 * var(--spacing-unit)) calc(-1 * var(--spacing-unit)); /* Extend background to edges */
            padding: var(--spacing-unit);
            border-top: 1px solid #eee;
        }

        /* Payment Methods */
        .payment-methods {
            display: flex;
            /* Removed padding from here, added to card-content */
            gap: calc(var(--spacing-unit) / 2);
            flex-wrap: wrap; /* Allow wrapping */
        }

        .payment-method {
            flex: 1 1 100px; /* Allow growing/shrinking, min width 100px */
            padding: var(--spacing-unit);
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: calc(var(--spacing-unit) / 3);
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
            text-align: center; /* Center text */
        }

         .payment-method:hover {
             background-color: rgba(0, 0, 0, 0.03); /* Subtle hover effect */
             border-color: #ccc;
         }

        .payment-method i {
            font-size: 1.8rem; /* Slightly larger icon */
            color: var(--secondary-color);
        }

        .payment-method.active {
            border-color: var(--primary-color);
            background-color: rgba(217, 78, 51, 0.08); /* Slightly stronger tint */
        }

        .payment-method.active i {
            color: var(--primary-color);
        }

        /* Payment Actions */
        .payment-actions {
            /* Removed padding from here, added to card-content */
            display: flex;
            gap: calc(var(--spacing-unit) / 2);
            flex-direction: column;
        }

        .btn {
            padding: 0.8rem var(--spacing-unit); /* Slightly more vertical padding */
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: calc(var(--spacing-unit) / 3);
            transition: var(--transition);
             font-size: 1rem;
        }

        .btn i {
            font-size: 1rem;
        }

        .btn-primary {
            background-color: var(--secondary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #695048; /* Darker secondary */
        }

        .btn-accent { /* Use primary for main action */
            background-color: var(--primary-color);
            color: white;
        }

        .btn-accent:hover {
            background-color: #c24129; /* Darker primary */
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--secondary-color); /* Outline color matches secondary */
            color: var(--secondary-color);
        }

        .btn-outline:hover {
            background-color: rgba(122, 97, 88, 0.08); /* Subtle secondary tint on hover */
        }

        .btn-light-close { /* New style for modal footer close */
             background-color: transparent;
             border: none;
             color: var(--secondary-color);
             padding: 0.8rem var(--spacing-unit);
             font-weight: 500;
        }
         .btn-light-close:hover {
            background-color: #eee;
         }


        /* Shortcuts Bar */
        .shortcuts-bar {
            display: flex;
            background-color: var(--secondary-color);
            color: white;
            padding: calc(var(--spacing-unit) / 2) var(--spacing-unit); /* Adjusted padding */
            min-height: 50px; /* Slightly reduced height */
            justify-content: center;
            align-items: center;
            gap: 2rem;
            font-size: 0.9rem;
            flex-wrap: wrap; /* Allow wrapping on small screens */
        }

        .shortcut {
            display: flex;
            align-items: center;
            gap: calc(var(--spacing-unit) / 3);
        }

        .key {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 0.2rem 0.4rem; /* Adjusted padding */
            border-radius: 4px;
            font-family: monospace;
            font-size: 0.85rem;
            font-weight: bold;
        }

        /* Modal */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6); /* Slightly darker overlay */
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000; /* Higher z-index */
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .modal.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background-color: white;
            border-radius: var(--border-radius);
            width: 100%;
            max-width: 550px; /* Slightly wider modal */
            max-height: 90vh; /* Allow slightly taller modal */
            overflow: hidden; /* Contains scrolling within content */
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12); /* Slightly more prominent shadow */
            display: flex; /* Make modal content flex */
            flex-direction: column; /* Stack header, content, actions */
            animation: modalSlideIn 0.3s ease forwards;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(30px); /* Slide in further */
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            padding: var(--spacing-unit);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            flex-shrink: 0; /* Prevent header from shrinking */
        }

        .modal-title {
            font-weight: 600; /* Slightly bolder */
            font-size: 1.25rem;
        }

        .modal-close {
            cursor: pointer;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: var(--transition);
             font-size: 1.1rem;
             color: #888; /* Softer color */
        }

        .modal-close:hover {
            background-color: #eee; /* Use light color for hover */
            color: var(--dark-color);
        }

        .receipt-content {
            padding: 1.5rem; /* Generous padding */
            overflow-y: auto; /* Enable scrolling */
            flex-grow: 1; /* Allow content to fill space */
             /* Removed max-height here, relying on flex-grow and modal-content max-height */
        }

        .receipt-header {
            text-align: center;
            margin-bottom: var(--spacing-unit) * 1.5; /* More space below header */
             padding-bottom: var(--spacing-unit);
             border-bottom: 2px dashed #ddd; /* More prominent dashed line */
        }

        .receipt-header h2 {
            margin-bottom: calc(var(--spacing-unit) / 3);
            color: var(--primary-color);
            font-size: 1.4rem;
        }
         .receipt-header p {
             font-size: 0.9rem;
             line-height: 1.4;
             color: #555;
         }


        .receipt-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: calc(var(--spacing-unit) / 2);
            margin-bottom: var(--spacing-unit) * 1.5;
            border-bottom: 1px dashed #ddd;
            padding-bottom: var(--spacing-unit);
             font-size: 0.9rem;
             color: #555;
        }

        .receipt-info > div {
            display: flex;
            justify-content: space-between;
        }
         .receipt-info > div span:first-child {
             font-weight: 500;
             color: var(--dark-color);
         }


        .receipt-items {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-unit); /* Spacing between items */
            margin-bottom: var(--spacing-unit) * 1.5;
        }

        .receipt-item {
            padding-bottom: var(--spacing-unit);
            border-bottom: 1px solid #eee;
        }

        .receipt-item-detail {
            display: flex;
            justify-content: space-between;
            font-weight: 500;
             font-size: 1rem;
             margin-bottom: 4px; /* Space below detail line */
        }

         .receipt-item-detail .receipt-item-name {
             flex-grow: 1; /* Allow name to take space */
             padding-right: var(--spacing-unit); /* Space before price */
         }


        .receipt-item-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: #777;
        }

        .receipt-summary {
            display: flex;
            flex-direction: column;
            gap: calc(var(--spacing-unit) / 2);
            margin-bottom: var(--spacing-unit) * 1.5;
            border-top: 1px dashed #ddd;
            padding-top: var(--spacing-unit);
            font-size: 1rem;
        }

        .receipt-summary > div {
            display: flex;
            justify-content: space-between;
        }
         .receipt-summary > div span:first-child {
             font-weight: 500;
         }

        .receipt-total {
            font-weight: bold;
            font-size: 1.3rem; /* Larger total font */
            margin-top: var(--spacing-unit); /* More space above total */
            padding-top: var(--spacing-unit);
            border-top: 2px solid #ddd;
        }

        .receipt-qr {
            display: flex;
            justify-content: center;
            margin: var(--spacing-unit) * 2 0; /* More vertical space */
            font-size: 6rem; /* Larger QR code */
            color: var(--dark-color);
            opacity: 0.8; /* Slight transparency */
        }

        .receipt-footer {
            text-align: center;
            color: #777;
            font-size: 0.9rem;
            line-height: 1.4;
        }
         .receipt-footer p:first-child {
             margin-bottom: calc(var(--spacing-unit) / 2);
         }


        .modal-actions {
            padding: var(--spacing-unit);
            display: flex;
            justify-content: flex-end; /* Align buttons to the right */
            gap: calc(var(--spacing-unit) / 2);
            border-top: 1px solid #eee;
            flex-shrink: 0; /* Prevent actions from shrinking */
            flex-wrap: wrap; /* Allow buttons to wrap */
        }
         .modal-actions .btn {
             flex-grow: 1; /* Allow buttons to grow */
             flex-basis: auto; /* Reset base */
             max-width: 150px; /* Limit max width for better layout */
         }
         @media (max-width: 480px) {
             .modal-actions {
                 flex-direction: column; /* Stack buttons vertically */
             }
             .modal-actions .btn {
                 max-width: none; /* No max-width when stacked */
             }
         }


        /* Responsive Styling */
        @media (max-width: 992px) { /* Adjust breakpoint for slightly larger tablets */
             .main-container {
                flex-direction: column;
                padding: calc(var(--spacing-unit) / 2); /* Less padding */
                gap: calc(var(--spacing-unit) / 2);
            }
             .payment-panel {
                 max-width: none; /* Remove max-width on small screens */
             }
             .shortcuts-bar {
                overflow-x: auto;
                justify-content: flex-start;
                padding: calc(var(--spacing-unit) / 2);
                gap: var(--spacing-unit); /* Smaller gap */
            }
        }


        @media (max-width: 768px) {
            .cart-header {
                grid-template-columns: 2.5fr 1fr 1fr 1fr 40px; /* Adjust grid */
            }

            .cart-header div:nth-child(3), /* Hide Unit Price in header */
            .cart-row .cart-price { /* Hide Unit Price in rows */
                display: none;
            }

            .cart-row {
                grid-template-columns: 2.5fr 1fr 1fr 1fr 40px; /* Adjust grid */
            }

             .product-info {
                 gap: calc(var(--spacing-unit) / 2); /* Smaller gap */
             }

            .product-image {
                display: none; /* Hide product image */
            }
             .modal-content {
                 width: 95%;
             }
        }

         @media (max-width: 480px) {
             .quick-add {
                 padding: calc(var(--spacing-unit) / 3); /* Less padding */
                 gap: calc(var(--spacing-unit) / 3); /* Less gap */
             }
             .quick-item {
                 padding: calc(var(--spacing-unit) / 3) calc(var(--spacing-unit) / 2); /* Less padding */
                 font-size: 0.85rem;
             }
             .search-bar {
                 padding: calc(var(--spacing-unit) / 2);
             }
             .search-input input {
                 padding: 0.6rem calc(var(--spacing-unit) / 2);
                 font-size: 0.9rem;
             }
              .cart-items {
                 padding: 0 calc(var(--spacing-unit) / 2); /* Less padding */
              }
             .cart-row {
                 grid-template-columns: 2fr 1fr 1fr 30px; /* Further adjust grid */
                 padding: calc(var(--spacing-unit) * 0.8) 0; /* Slightly less padding */
             }
             .cart-header {
                 grid-template-columns: 2fr 1fr 1fr 30px; /* Further adjust grid */
                 padding: calc(var(--spacing-unit) * 0.8) 0;
                 font-size: 0.85rem;
             }
             
             /* Stack discount under quantity on mobile */
             .cart-discount {
                 grid-row: 2;
                 grid-column: 1 / -1;
                 display: flex;
                 justify-content: flex-start;
                 padding-top: 0.5rem;
                 padding-left: 0.5rem;
                 align-items: center;
             }
             
             .cart-discount:before {
                 content: 'Discount:';
                 margin-right: 0.5rem;
                 font-size: 0.85rem;
                 color: var(--secondary-color);
             }
             
             .discount-select {
                 max-width: 100px;
                 font-size: 0.85rem;
                 padding: 3px 6px;
                 padding-right: 24px;
             }
             
             .cart-quantity {
                 gap: calc(var(--spacing-unit) / 4);
             }
             
             .qty-btn {
                width: 20px;
                height: 20px;
                font-size: 0.7rem;
              }
              .qty-value {
                 min-width: 24px;
                  padding: 0.1rem 0.3rem;
                  font-size: 0.85rem;
              }
              .cart-total {
                 font-size: 0.9rem;
              }
              .cart-action {
                font-size: 1rem; /* Smaller icon */
                width: 30px; /* Match grid column */
              }
              .summary-card .card-content,
              .payment-card .card-content {
                padding: calc(var(--spacing-unit) / 2); /* Less padding inside cards */
                gap: calc(var(--spacing-unit) / 2); /* Less gap */
              }
              .summary-row,
              .payment-methods,
              .payment-actions {
                 gap: calc(var(--spacing-unit) / 2); /* Less gap */
              }
              .grand-total {
                 margin: var(--spacing-unit) calc(-1 * var(--spacing-unit) / 2); /* Adjust margin */
                 padding: calc(var(--spacing-unit) / 2); /* Less padding */
              }

             .receipt-content {
                 padding: var(--spacing-unit); /* Less padding in receipt */
             }
             .receipt-header h2 {
                 font-size: 1.2rem;
             }
             .receipt-info {
                 grid-template-columns: 1fr; /* Stack receipt info */
             }
             .receipt-summary {
                 font-size: 0.95rem;
             }
             .receipt-total {
                 font-size: 1.1rem;
             }
              .receipt-qr {
                 font-size: 4rem;
              }
              .modal-actions {
                 padding: calc(var(--spacing-unit) / 2); /* Less padding */
              }
         }


        /* Font Awesome Icons */
        
        /* Search Results Styling */
        .search-results-container {
            margin-bottom: 1.5rem;
            background-color: var(--surface-white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-subtle);
            overflow: hidden;
        }
        
        .search-results-title {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            background-color: var(--color-primary-light);
            color: var(--color-primary-dark);
            margin: 0;
            font-size: 0.95rem;
            font-weight: 600;
            border-bottom: 1px solid var(--color-border);
        }
        
        .search-results-title i {
            margin-right: 0.5rem;
        }
        
        .results-count {
            font-weight: normal;
            color: var(--text-secondary);
            margin-left: 0.5rem;
            font-size: 0.85rem;
        }
        
        .search-results {
            padding: 0.75rem;
            max-height: 320px;
            overflow-y: auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 0.75rem;
        }
        
        .product-card {
            background-color: var(--surface-white);
            border-radius: var(--border-radius);
            border: 1px solid var(--color-border);
            overflow: hidden;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
        }
        
        .product-card:hover {
            border-color: var(--primary-red);
            box-shadow: var(--shadow-subtle);
            transform: translateY(-2px);
        }
        
        .product-info {
            padding: 0.75rem;
            flex: 1;
        }
        
        .product-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: var(--text-primary);
            font-size: 0.95rem;
        }
        
        .product-category {
            color: var(--text-secondary);
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
            text-transform: capitalize;
        }
        
        .product-price {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-red);
            margin-bottom: 0.5rem;
        }
        
        .product-stock {
            margin-bottom: 0.5rem;
        }
        
        .stock-badge {
            font-size: 10px;
            padding: 2px 5px;
            border-radius: 10px;
            white-space: nowrap;
        }
        
        .in-stock {
            background-color: #E8F5E9;
            color: #2E7D32;
            border: 1px solid #A5D6A7;
        }
        
        .medium-stock {
            background-color: #FFF3E0;
            color: #E65100;
            border: 1px solid #FFCC80;
        }
        
        .low-stock {
            background-color: #FFEBEE;
            color: #C62828;
            border: 1px solid #FFCDD2;
        }
        
        .product-actions {
            padding: 0.5rem;
            background-color: #f8f9fa;
            border-top: 1px solid var(--color-border);
        }
        
        .add-to-cart-btn {
            width: 100%;
            background-color: var(--primary-red);
            color: white;
            border: none;
            padding: 0.5rem;
            font-size: 0.85rem;
            border-radius: var(--border-radius-sm);
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .add-to-cart-btn:hover {
            background-color: var(--primary-red-dark);
        }
        
        .no-results, .empty-cart {
             display: flex;
             flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background-color: var(--surface-white);
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
            color: var(--text-secondary);
            border: 1px solid var(--color-border);
        }
        
        .no-results i, .empty-cart i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--text-muted);
        }
        
        .no-results p, .empty-cart p {
            margin: 0;
            font-size: 1rem;
            font-weight: 500;
        }
        
        .no-results .tip, .empty-cart .tip {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
        }

        /* Dropdown Search Results Styling */
        .dropdown-search-results {
            margin-bottom: 1rem;
            background-color: #fff;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            position: relative;
            z-index: 100;
            border: 1px solid #ddd;
        }
        
        .search-info {
            padding: 8px 12px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }
        
        .product-results-list {
            list-style: none;
            margin: 0;
            padding: 0;
            max-height: 300px;
            overflow-y: auto;
        }
        
        .product-result-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s ease;
        }
        
        .product-result-item:hover {
            background-color: #f5f5f5;
        }
        
        .product-result-info {
            flex: 1;
        }
        
        .product-result-name {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 4px;
        }
        
        .product-result-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 12px;
        }
        
        .product-result-category {
            color: #666;
            text-transform: capitalize;
        }
        
        .product-result-price {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .product-result-add {
            background: linear-gradient(90deg, #D94E33 0%, #FF7E5F 100%);
            color: white;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: box-shadow 0.2s, transform 0.2s, background 0.2s;
            box-shadow: 0 2px 8px rgba(217, 78, 51, 0.10);
            font-size: 1.1rem;
            position: relative;
        }
        .product-result-add:hover {
            background: linear-gradient(90deg, #FF7E5F 0%, #D94E33 100%);
            transform: scale(1.15);
            box-shadow: 0 4px 16px 0 rgba(217, 78, 51, 0.18), 0 0 0 4px rgba(255, 126, 95, 0.10);
        }
        .product-result-add::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 50%;
            bottom: 110%;
            transform: translateX(-50%);
            background: #222;
            color: #fff;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s, transform 0.2s;
            z-index: 10;
        }
        .product-result-add:hover::after {
            opacity: 1;
            transform: translateX(-50%) translateY(-4px);
        }
        
        /* Loading indicator */
        .search-loading {
            padding: 10px;
            text-align: center;
            background-color: #fff;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            margin-bottom: 0.5rem;
            color: var(--secondary-color);
            font-size: 0.9rem;
        }
        
        .search-loading i {
            margin-right: 5px;
            color: var(--primary-color);
        }
        
        /* Error message */
        .search-error {
            padding: 20px;
            text-align: center;
            background-color: #fff;
            border-radius: var(--border-radius);
        }
        
        .search-error i {
            font-size: 2rem;
            color: #dc3545;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .search-error p {
            margin: 0;
            font-size: 1rem;
            font-weight: 500;
        }
        
        .search-error .tip {
            font-size: 0.85rem;
            color: #666;
            margin-top: 0.5rem;
        }

        .remove-btn {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ff5858 0%, #f857a6 100%);
            border: none;
            color: #fff;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(.4,0,.2,1);
            border-radius: 10px;
            font-size: 1.1rem;
            box-shadow: 0 2px 8px rgba(248, 87, 166, 0.10);
            outline: none;
        }
        .remove-btn:hover, .remove-btn:focus {
            background: linear-gradient(135deg, #f857a6 0%, #ff5858 100%);
            box-shadow: 0 4px 16px rgba(248, 87, 166, 0.18);
            transform: scale(1.12) rotate(-8deg);
        }
        .remove-btn:active {
            background: linear-gradient(135deg, #ff5858 0%, #f857a6 100%);
            box-shadow: 0 1px 4px rgba(248, 87, 166, 0.10);
            transform: scale(0.95);
        }

        .cart-discount {
            text-align: center;
        }
        
        .discount-select {
            padding: 5px 8px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            background: white;
            font-size: 0.9rem;
            color: var(--dark-color);
            cursor: pointer;
            transition: all 0.2s ease;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 8px center;
            padding-right: 28px;
            width: 100%;
            max-width: 120px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .discount-select:hover, .discount-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 2px 8px rgba(217, 78, 51, 0.1);
            outline: none;
        }
        
        .discount-select option {
            padding: 5px;
        }

        /* Receipt styling updates */
        .receipt-row {
            display: flex;
            justify-content: space-between;
        }

        .receipt-row-visible {
            display: flex;
        }

        .receipt-row-hidden {
            display: none;
        }

        .receipt-item {
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px dashed #eee;
        }

        .receipt-item-detail {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .receipt-item-name {
            font-weight: 500;
            color: var(--dark-color);
            flex: 1;
        }

        .receipt-item-total {
            font-weight: 500;
        }

        .receipt-item-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: #777;
        }

        .receipt-item-qty {
            background-color: #f8f8f8;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: monospace;
        }

        .receipt-item-discount {
            color: var(--danger-color);
            font-weight: 500;
        }

        .toast-progress-bar {
            height: 100%;
            width: 100%;
            background: rgba(255, 255, 255, 0.7);
            transform-origin: left;
            animation: progress 3s linear forwards;
        }

        @keyframes progress {
            from {
                transform: scaleX(1);
            }
            to {
                transform: scaleX(0);
            }
        }

        /* Add these CSS styles in the style section */
        .receipt-item-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: #777;
            margin-top: 4px;
        }

        .receipt-item-price {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .receipt-item-qty {
            background-color: #f8f8f8;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: monospace;
        }

        .receipt-item-discount {
            color: #dc3545;
            font-weight: 500;
        }

        .receipt-item-subtotal {
            font-weight: 500;
            color: #555;
        }

        .receipt-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
        }

        .discount-highlight {
            color: #dc3545;
            font-weight: 500;
        }

        .receipt-total {
            font-weight: bold;
            font-size: 1.3rem;
            margin-top: var(--spacing-unit);
            padding-top: var(--spacing-unit);
            border-top: 2px solid #ddd;
            display: flex;
            justify-content: space-between;
        }
    </style>
    
    <!-- Toast Notification System -->
    <style>
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 350px;
        }
        
        .toast {
            padding: 16px;
            border-radius: 8px;
            color: white;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateX(120%);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            overflow: hidden;
            position: relative;
        }
        
        .toast.active {
            transform: translateX(0);
            opacity: 1;
        }
        
        .toast-success {
            background: linear-gradient(to right, #28a745, #43c066);
            border-left: 4px solid #1e7e34;
        }
        
        .toast-error {
            background: linear-gradient(to right, #dc3545, #f65b69);
            border-left: 4px solid #bd2130;
        }
        
        .toast-warning {
            background: linear-gradient(to right, #ffc107, #ffdb4d);
            color: #333;
            border-left: 4px solid #d39e00;
        }
        
        .toast-info {
            background: linear-gradient(to right, #17a2b8, #45c4d7);
            border-left: 4px solid #138496;
        }
        
        .toast-icon {
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .toast-content {
            flex: 1;
        }
        
        .toast-message {
            margin: 0;
            font-weight: 500;
            font-size: 0.95rem;
            line-height: 1.4;
        }
        
        .toast-close {
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s;
            padding: 0;
            background: none;
            border: none;
            color: inherit;
            font-size: 1.2rem;
        }
        
        .toast-close:hover {
            opacity: 1;
        }
        
        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            width: 100%;
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>
    <!-- Toast Container -->
    <div class="toast-container" id="toast-container"></div>
    
    <!-- Top Bar -->
    <div class="topbar">
        <div class="topbar-left">
            <img src="{{ asset('images/logo.png') }}" alt="Red Panda Logo" class="topbar-logo">
            <span class="topbar-title">Red Panda POS</span>
        </div>
        <div class="topbar-center">
            <span class="topbar-date">{{ now()->setTimezone('Asia/Phnom_Penh')->format('F j, Y') }}</span>
            <span class="topbar-time" id="current-time">{{ now()->setTimezone('Asia/Phnom_Penh')->format('h:i A') }}</span>
        </div>
        <div class="topbar-right">
            <div class="topbar-user">
                <div class="avatar">
                    @if(Auth::user()->profile_image)
                        <img src="{{ asset('images/profiles/' . Auth::user()->profile_image) }}" alt="{{ Auth::user()->name }}" class="avatar-img">
                    @else
                        {{ substr(Auth::user()->name, 0, 1) }}
                    @endif
                </div>
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role">{{ Auth::user()->role }}</span>
                </div>
            </div>
            <a href="{{ route('logout') }}" class="btn-logout" id="logout-btn" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Left Panel - Cart -->
        <div class="cart-panel">
            <form action="{{ url('home/cashier/search-product') }}" method="GET" class="search-form" style="margin-bottom: 1rem;">
                <div class="search-input">
                    <input type="text" name="search" placeholder="Search product..." value="{{ $query ?? '' }}" autofocus>
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <!-- Search Results Section (displayed only when search is explicitly performed) -->
            @if(isset($products) && count($products) > 0 && (isset($query) || isset($searchPerformed)))
                <div class="dropdown-search-results">
                    <div class="search-info">
                        <span>Found {{ count($products) }} result(s) {{ isset($query) && !empty($query) ? 'for "'.$query.'"' : '' }}</span>
            </div>
                    <ul class="product-results-list">
                        @foreach($products as $product)
                            <li class="product-result-item">
                                <div class="product-result-info">
                                    <div class="product-result-name">{{ $product->product_name }}</div>
                                    <div class="product-result-meta">
                                        <span class="product-result-category">{{ $product->category }}</span>
                                        <span class="product-result-price">${{ number_format($product->price, 2) }}</span>
                                        <span class="product-result-stock">
                                            @if($product->qty > 50)
                                                <span class="stock-badge in-stock">In Stock</span>
                                            @elseif($product->qty > 30)
                                                <span class="stock-badge medium-stock">Medium Stock</span>
                                            @else
                                                <span class="stock-badge low-stock">Low Stock</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <form action="{{ url('/home/cashier/confirm-product') }}" method="POST" class="add-to-cart-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="product-result-add" data-tooltip="Add to Cart">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @elseif(isset($query) && !empty($query))
                <div class="no-results">
                    <i class="fas fa-search"></i>
                    <p>No products found for "{{ $query }}"</p>
                    <p class="tip">Try searching for a different term or category</p>
                </div>
            @endif

            <div class="quick-add">
                <div class="quick-item" data-category="Fruits">Fruits</div>
                <div class="quick-item" data-category="Vegetables">Vegetables</div>
                <div class="quick-item" data-category="Dairy">Dairy</div>
                <div class="quick-item" data-category="Bakery">Bakery</div>
                <div class="quick-item" data-category="Meat">Meat</div>
                <div class="quick-item" data-category="Beverages">Beverages</div>
                <div class="quick-item" data-category="Snacks">Snacks</div>
                <div class="quick-item" data-category="Household">Household</div>
                <div class="quick-item" data-category="Electronics">Electronics</div>
                <div class="quick-item" data-category="Clothing">Clothing</div>
            </div>

            <div class="cart-items">
                <div class="cart-header">
                    <div>Product</div>
                    <div>Quantity</div>
                    <div>Unit Price</div>
                    <div>Discount</div>
                    <div>Total</div>
                    <div></div>
                </div>
                @if(Session::has('cart') && count(Session::get('cart')) > 0)
                    @foreach(Session::get('cart') as $index => $item)
                <div class="cart-row">
                    <div class="product-info">
                        <div class="product-image">
                                    <i class="fas fa-box"></i>
                        </div>
                        <div>
                                    <div class="product-name">{{ $item['name'] }}</div>
                                    <div class="product-code">{{ $item['code'] ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="cart-quantity">
                                <button class="qty-btn minus-btn" data-index="{{ $index }}">-</button>
                                <span class="qty-value">{{ $item['quantity'] }}</span>
                                <button class="qty-btn plus-btn" data-index="{{ $index }}">+</button>
                        </div>
                            <div class="cart-price">${{ number_format($item['price'], 2) }}</div>
                            <div class="cart-discount">
                                <select class="discount-select" data-index="{{ $index }}">
                                    <option value="0" {{ ($item['discount'] ?? 0) == 0 ? 'selected' : '' }}>No Discount</option>
                                    <option value="5" {{ ($item['discount'] ?? 0) == 5 ? 'selected' : '' }}>5%</option>
                                    <option value="10" {{ ($item['discount'] ?? 0) == 10 ? 'selected' : '' }}>10%</option>
                                    <option value="15" {{ ($item['discount'] ?? 0) == 15 ? 'selected' : '' }}>15%</option>
                                    <option value="20" {{ ($item['discount'] ?? 0) == 20 ? 'selected' : '' }}>20%</option>
                                    <option value="25" {{ ($item['discount'] ?? 0) == 25 ? 'selected' : '' }}>25%</option>
                                    <option value="50" {{ ($item['discount'] ?? 0) == 50 ? 'selected' : '' }}>50%</option>
                                </select>
                            </div>
                            <div class="cart-total">${{ number_format($item['subtotal'], 2) }}</div>
                    <div class="cart-action">
                                <form action="{{ url('/home/cashier/remove-from-cart') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="index" value="{{ $index }}">
                                    <button type="submit" class="remove-btn">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                    </div>
                </div>
                    @endforeach
                @else
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <p>Your cart is empty</p>
                        <p class="tip">Search for products to add to your cart</p>
                        </div>
                @endif
            </div>
        </div>

        <!-- Right Panel - Payment -->
        <div class="payment-panel">
            <div class="summary-card">
                <div class="card-title">
                    <span>Order Summary</span>
                    <i class="fas fa-shopping-basket"></i>
                </div>
                <div class="card-content"> <!-- Wrapper for card body -->
                     <div class="summary-row">
                         <div class="summary-label">Subtotal ({{ Session::has('cart') ? count(Session::get('cart')) : 0 }} items)</div>
                         <div class="summary-value">${{ Session::has('cart') ? number_format(collect(Session::get('cart'))->sum('subtotal'), 2) : '0.00' }}</div>
                     </div>
                     <div class="summary-row">
                         @php
                             $subtotal = Session::has('cart') ? collect(Session::get('cart'))->sum('subtotal') : 0;
                             
                             // Use current tax rate from controller if available
                             if (!isset($currentTaxRate)) {
                                 // Default to 6% if not provided
                                 $currentTaxRate = 6.0;
                                 
                                 // Try to get it from the app container if a tax rate service exists
                                 if (app()->bound('current_tax_rate')) {
                                     $currentTaxRate = app('current_tax_rate');
                                 }
                             }
                             
                             $tax = $subtotal * ($currentTaxRate / 100);
                             
                             // Calculate total discount amount
                             $totalDiscount = 0;
                             if (Session::has('cart')) {
                                 $cart = Session::get('cart');
                                 foreach ($cart as $item) {
                                     if (isset($item['discount']) && $item['discount'] > 0) {
                                         $originalSubtotal = $item['quantity'] * $item['price'];
                                         $discountedSubtotal = $item['subtotal'];
                                         $totalDiscount += ($originalSubtotal - $discountedSubtotal);
                                     }
                                 }
                             }
                         @endphp
                         <div class="summary-label">Tax ({{ number_format($currentTaxRate, 1) }}%)</div>
                         <div class="summary-value">${{ number_format($tax, 2) }}</div>
                     </div>
                     @if($totalDiscount > 0)
                     <div class="summary-row discount-row">
                         <div class="summary-label">Total Discount</div>
                         <div class="summary-value">-${{ number_format($totalDiscount, 2) }}</div>
                     </div>
                     @endif
                </div>
                 <div class="grand-total">
                    @php
                        $grandTotal = $subtotal + $tax;
                    @endphp
                     <div class="summary-label">Grand Total</div>
                    <div class="summary-value">${{ number_format($grandTotal, 2) }}</div>
                 </div>
            </div>

            <div class="payment-card">
                <div class="card-title">
                    <span>Payment Method</span>
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="card-content"> <!-- Wrapper for card body -->
                    <div class="payment-methods">
                        <div class="payment-method active">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Cash</span>
                        </div>
                        <div class="payment-method">
                            <i class="fas fa-credit-card"></i>
                            <span>Card</span>
                        </div>
                                        <div class="payment-method">
                    <i class="fas fa-wallet"></i>
                    <span>Wallet</span>
                </div>
            </div>
            <div class="payment-actions">
                <button class="btn btn-primary" id="print-receipt-btn">
                    <i class="fas fa-print"></i>
                    Print Receipt
                </button>
                <button class="btn btn-accent" id="complete-sale-btn">
                    <i class="fas fa-check-circle"></i>
                    Complete Sale
                </button>
            </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Shortcuts -->
    <div class="shortcuts-bar">
        <div class="shortcut">
            <span class="key">F1</span>
            <span>Search Products</span>
        </div>
        <div class="shortcut">
            <span class="key">F2</span>
            <span>Customer Search</span>
        </div>
        <div class="shortcut">
            <span class="key">F4</span>
            <span>Apply Discount</span>
        </div>
        <div class="shortcut">
            <span class="key">F12</span>
            <span>Complete Sale</span>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div class="modal" id="receipt-modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Receipt Preview</div>
                <div class="modal-close">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="receipt-content">
                <div class="receipt-header">
                    <h2>Red Panda Supermarket</h2>
                    <p>123 Market Street<br>City, State 12345<br>Tel: (555) 123-4567</p>
                </div>
                <div class="receipt-info">
                    <div>
                        <span>Date:</span>
                        <span>{{ now()->setTimezone('Asia/Phnom_Penh')->format('M j, Y g:i:s A') }}</span>
                    </div>
                    <div>
                        <span>Receipt #:</span>
                        <span id="receipt-invoice-number">INV-{{ now()->setTimezone('Asia/Phnom_Penh')->format('Ymd') }}{{ rand(1000, 9999) }}</span>
                    </div>
                    <div>
                        <span>Cashier:</span>
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                    <div>
                        <span>Payment Method:</span>
                        <span id="receipt-payment-method">Cash</span>
                    </div>
                </div>
                <div class="receipt-items" id="receipt-items-container">
                    <!-- Receipt items will be dynamically updated via JavaScript -->
                </div>
                <div class="receipt-summary" id="receipt-summary-container">
                    <!-- Receipt summary will be dynamically updated via JavaScript -->
                </div>
                <div class="receipt-qr">
                    <i class="fas fa-qrcode"></i>
                </div>
                <div class="receipt-footer">
                    <p>Thank you for shopping at Red Panda Supermarket!<br>Please visit again soon</p>
                    <p style="margin-top: 10px">--- www.redpanda-market.com ---</p>
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn btn-primary">
                    <i class="fas fa-print"></i>
                    Print
                </button>
                <button class="btn btn-outline">
                    <i class="fas fa-envelope"></i>
                    Email
                </button>
                <button class="btn btn-light-close modal-close-footer-btn">
                    <i class="fas fa-times"></i>
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        // Time Display Functions
        function updateTime() {
            const timeElement = document.getElementById('current-time');
            // Only proceed if the element exists
            if (timeElement) {
                // Get the current time and adjust for Cambodia timezone (UTC+7)
                const now = new Date();
                 // UTC+7 offset in minutes: 7 * 60 = 420
                 // Browser's timezone offset in minutes: now.getTimezoneOffset()
                 // Difference to add/subtract: (420 - now.getTimezoneOffset()) * 60 * 1000 (milliseconds)
                const localOffset = now.getTimezoneOffset() * 60 * 1000; // in milliseconds
                const cambodiaOffset = 7 * 60 * 60 * 1000; // in milliseconds
                const cambodiaTime = new Date(now.getTime() + cambodiaOffset + localOffset);

                timeElement.textContent = cambodiaTime.toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                });
            }
        }

        // Update time every second
        setInterval(updateTime, 1000);
        updateTime(); // Initial call

        // Main Document Ready Function
        document.addEventListener('DOMContentLoaded', function() {
            // Quick item category search functionality
            const quickItems = document.querySelectorAll('.quick-item');
            quickItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Get the category from data attribute
                    const category = this.dataset.category;
                    
                    // Update active state
                    quickItems.forEach(qi => qi.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Show loading indicator
                    let loadingIndicator = document.querySelector('.search-loading');
                    if (!loadingIndicator) {
                        loadingIndicator = document.createElement('div');
                        loadingIndicator.className = 'search-loading';
                        loadingIndicator.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading products from ' + category + ' category...';
                        const searchForm = document.querySelector('.search-form');
                        searchForm.after(loadingIndicator);
                    } else {
                        loadingIndicator.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading products from ' + category + ' category...';
                    }
                    
                    // Clear previous results
                    const existingResults = document.querySelector('.dropdown-search-results');
                    if (existingResults) {
                        existingResults.remove();
                    }
                    
                    // Make AJAX request to search by category
                    fetch(`/home/cashier/search-product?category=${encodeURIComponent(category)}&ajax=1`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Remove loading indicator
                            if (loadingIndicator) {
                                loadingIndicator.remove();
                            }
                            
                            if (data.success && Array.isArray(data.products) && data.products.length > 0) {
                                displaySearchResults(data.products, category);
                            } else if (data.success && data.count === 0) {
                                displayNoResults(category);
                            } else {
                                console.error('Invalid response format:', data);
                                displayNoResults(category);
                            }
                        })
                        .catch(error => {
                            // Remove loading indicator
                            if (loadingIndicator) {
                                loadingIndicator.remove();
                            }
                            
                            console.error('Error searching by category:', error);
                            Toast.error('Failed to load products for this category');
                        });
                });
            });
            
            // Real-time search functionality
            const searchInput = document.querySelector('.search-input input');
            let typingTimer;
            const doneTypingInterval = 500; // Wait 500ms after user stops typing
            
            if (searchInput) {
                // Handle form submission only - removed keyup listener
                const searchForm = document.querySelector('.search-form');
                if (searchForm) {
                    searchForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        performSearch();
                    });
                }
            }
            
            // Function to perform AJAX search
            function performSearch() {
                const query = searchInput.value.trim();
                
                if (!query) {
                    clearSearchResults();
                    return;
                }
                
                // Add loading indicator
                let loadingIndicator = document.querySelector('.search-loading');
                if (!loadingIndicator) {
                    loadingIndicator = document.createElement('div');
                    loadingIndicator.className = 'search-loading';
                    loadingIndicator.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
                    const searchForm = document.querySelector('.search-form');
                    searchForm.after(loadingIndicator);
                }
                
                // Clear previous results while loading
                const existingResults = document.querySelector('.dropdown-search-results');
                if (existingResults) {
                    existingResults.remove();
                }
                
                fetch(`/home/cashier/search-product?search=${encodeURIComponent(query)}&ajax=1`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Remove loading indicator
                        if (loadingIndicator) {
                            loadingIndicator.remove();
                        }
                        
                        console.log('Search response:', data);
                        
                        if (data.success && Array.isArray(data.products) && data.products.length > 0) {
                            displaySearchResults(data.products, query || 'all products');
                        } else if (data.success && data.count === 0) {
                            displayNoResults(query);
                        } else {
                            console.error('Invalid response format:', data);
                            displayNoResults(query);
                        }
                    })
                    .catch(error => {
                        // Remove loading indicator
                        if (loadingIndicator) {
                            loadingIndicator.remove();
                        }
                        
                        console.error('Error performing search:', error);
                        displaySearchError();
                    });
            }
            
            // Function to display search results
            function displaySearchResults(products, query) {
                // Remove any existing results container
                clearSearchResults();
                
                // Create a new results container
                const resultsContainer = document.createElement('div');
                resultsContainer.className = 'dropdown-search-results';
                const searchForm = document.querySelector('.search-form');
                searchForm.after(resultsContainer);
                
                let html = `
                    <div class="search-info">
                        <span>Found ${products.length} result(s) for "${query}"</span>
                    </div>
                    <ul class="product-results-list">
                `;
                
                products.forEach(product => {
                    let stockBadge = '';
                    if (product.qty > 50) {
                        stockBadge = '<span class="stock-badge in-stock">In Stock</span>';
                    } else if (product.qty > 30) {
                        stockBadge = '<span class="stock-badge medium-stock">Medium Stock</span>';
                    } else {
                        stockBadge = '<span class="stock-badge low-stock">Low Stock</span>';
                    }
                    
                    html += `
                        <li class="product-result-item">
                            <div class="product-result-info">
                                <div class="product-result-name">${product.product_name}</div>
                                <div class="product-result-meta">
                                    <span class="product-result-category">${product.category}</span>
                                    <span class="product-result-price">$${parseFloat(product.price).toFixed(2)}</span>
                                    <span class="product-result-stock">${stockBadge}</span>
                                </div>
                            </div>
                            <form action="/home/cashier/confirm-product" method="POST" class="add-to-cart-form">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                <input type="hidden" name="product_id" value="${product.id}">
                                <button type="submit" class="product-result-add" data-tooltip="Add to Cart">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>
                        </li>
                    `;
                });
                
                html += `</ul>`;
                resultsContainer.innerHTML = html;
                
                // Add event listeners to the add buttons
                document.querySelectorAll('.add-to-cart-form').forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const formData = new FormData(form);
                        
                        fetch('/home/cashier/confirm-product', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update cart items section
                                const cartItems = document.querySelector('.cart-items');
                                if (data.cart && data.cart.length > 0) {
                                    let cartHtml = `
                                        <div class="cart-header">
                                            <div>Product</div>
                                            <div>Quantity</div>
                                            <div>Unit Price</div>
                                            <div>Discount</div>
                                            <div>Total</div>
                                            <div></div>
                                        </div>
                                    `;
                                    
                                    data.cart.forEach((item, index) => {
                                        cartHtml += `
                                            <div class="cart-row">
                                                <div class="product-info">
                                                    <div class="product-image">
                                                        <i class="fas fa-box"></i>
                                                    </div>
                                                    <div>
                                                        <div class="product-name">${item.name}</div>
                                                        <div class="product-code">${item.code || 'N/A'}</div>
                                                    </div>
                                                </div>
                                                <div class="cart-quantity">
                                                    <button class="qty-btn minus-btn" data-index="${index}">-</button>
                                                    <span class="qty-value">${item.quantity}</span>
                                                    <button class="qty-btn plus-btn" data-index="${index}">+</button>
                                                </div>
                                                <div class="cart-price">$${parseFloat(item.price).toFixed(2)}</div>
                                                <div class="cart-discount">
                                                    <select class="discount-select" data-index="${index}">
                                                        <option value="0" ${item.discount == 0 ? 'selected' : ''}>No Discount</option>
                                                        <option value="5" ${item.discount == 5 ? 'selected' : ''}>5%</option>
                                                        <option value="10" ${item.discount == 10 ? 'selected' : ''}>10%</option>
                                                        <option value="15" ${item.discount == 15 ? 'selected' : ''}>15%</option>
                                                        <option value="20" ${item.discount == 20 ? 'selected' : ''}>20%</option>
                                                        <option value="25" ${item.discount == 25 ? 'selected' : ''}>25%</option>
                                                        <option value="50" ${item.discount == 50 ? 'selected' : ''}>50%</option>
                                                    </select>
                                                </div>
                                                <div class="cart-total">$${parseFloat(item.subtotal).toFixed(2)}</div>
                                                <div class="cart-action">
                                                    <form action="/home/cashier/remove-from-cart" method="POST" style="display:inline;">
                                                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                                        <input type="hidden" name="index" value="${index}">
                                                        <button type="submit" class="remove-btn">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        `;
                                    });
                                    
                                    cartItems.innerHTML = cartHtml;
                                } else {
                                    cartItems.innerHTML = `
                                        <div class="empty-cart">
                                            <i class="fas fa-shopping-cart"></i>
                                            <p>Your cart is empty</p>
                                            <p class="tip">Search for products to add to your cart</p>
                                        </div>
                                    `;
                                }
                                
                                // Update summary
                                updateCartSummary();
                            } else {
                                Toast.error(data.message || 'Failed to add product to cart');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Toast.error('Error adding product to cart');
                        });
                    });
                });
            }
            
            function displayNoResults(query) {
                // Remove any existing results container
                clearSearchResults();
                
                // Create a new results container
                const resultsContainer = document.createElement('div');
                resultsContainer.className = 'dropdown-search-results';
                const searchForm = document.querySelector('.search-form');
                searchForm.after(resultsContainer);
                
                resultsContainer.innerHTML = `
                    <div class="no-results">
                        <i class="fas fa-search"></i>
                        <p>No products found for "${query}"</p>
                        <p class="tip">Try searching for a different term or category</p>
                    </div>
                `;
            }
            
            function displaySearchError() {
                // Remove any existing results container
                clearSearchResults();
                
                // Create a new results container
                const resultsContainer = document.createElement('div');
                resultsContainer.className = 'dropdown-search-results';
                const searchForm = document.querySelector('.search-form');
                searchForm.after(resultsContainer);
                
                resultsContainer.innerHTML = `
                    <div class="search-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <p>Error searching for products</p>
                        <p class="tip">Please try again later</p>
                    </div>
                `;
            }
            
            // Function to clear search results
            function clearSearchResults() {
                const resultsContainer = document.querySelector('.dropdown-search-results');
                if (resultsContainer) {
                    resultsContainer.remove();
                }
                
                const loadingIndicator = document.querySelector('.search-loading');
                if (loadingIndicator) {
                    loadingIndicator.remove();
                }
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.search-form') && !e.target.closest('.dropdown-search-results')) {
                    clearSearchResults();
                }
            });

            // Handle quantity buttons
            const container = document.querySelector('.cart-items');
            if (container) {
                container.addEventListener('click', function(event) {
                    // Handle minus button click
                    if (event.target.classList.contains('minus-btn')) {
                        const index = event.target.dataset.index;
                        updateQuantity(index, 'decrease');
                    }
                    
                    // Handle plus button click
                    if (event.target.classList.contains('plus-btn')) {
                        const index = event.target.dataset.index;
                        updateQuantity(index, 'increase');
                    }
                });
                
                // Handle discount select changes
                container.addEventListener('change', function(event) {
                    if (event.target.classList.contains('discount-select')) {
                        const index = event.target.dataset.index;
                        const discountValue = parseInt(event.target.value);
                        updateDiscount(index, discountValue);
                    }
                });
            }
            
            // Function to update discount
            function updateDiscount(index, discountValue) {
                fetch(`/home/cashier/update-discount`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        index: index,
                        discount: discountValue
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the cart row with the new values
                        const cartRow = document.querySelector(`.cart-row:nth-child(${parseInt(index) + 2})`);
                        if (cartRow) {
                            const totalElement = cartRow.querySelector('.cart-total');
                            if (totalElement && data.item) {
                                totalElement.textContent = `$${parseFloat(data.item.subtotal).toFixed(2)}`;
                            }
                        }
                        // Update overall summary
                        updateCartSummary();
                        
                        // Show success toast instead of alert
                        Toast.success('Discount updated successfully');
                    } else {
                        Toast.error('Failed to update discount');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }

            // Function to update quantity
            function updateQuantity(index, action) {
                fetch(`/home/cashier/update-quantity`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        index: index,
                        action: action
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload the page to reflect the changes
                        window.location.reload();
                    } else {
                        Toast.error('Failed to update quantity');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Toast.error('Error updating quantity');
                });
            }

            // Modal handling
            const modal = document.getElementById('receipt-modal');
            const printReceiptBtn = document.getElementById('print-receipt-btn');
            const modalClose = document.querySelector('.modal-header .modal-close'); // Target header close
            const modalFooterClose = document.querySelector('.modal-actions .modal-close-footer-btn'); // Target footer close

            // Function to update receipt content
            function updateReceiptContent() {
                const receiptItemsContainer = document.getElementById('receipt-items-container');
                const receiptSummaryContainer = document.getElementById('receipt-summary-container');
                
                if (!receiptItemsContainer || !receiptSummaryContainer) return;
                
                // Get cart items from the DOM
                const cartRows = document.querySelectorAll('.cart-row');
                let itemsHtml = '';
                let subtotal = 0;
                let totalDiscount = 0;
                let originalSubtotal = 0;
                let itemCount = 0;
                
                if (cartRows.length > 0) {
                    cartRows.forEach(row => {
                        const productName = row.querySelector('.product-name').textContent;
                        const productCode = row.querySelector('.product-code').textContent;
                        const quantity = parseInt(row.querySelector('.qty-value').textContent);
                        const price = parseFloat(row.querySelector('.cart-price').textContent.replace('$', ''));
                        const total = parseFloat(row.querySelector('.cart-total').textContent.replace('$', ''));
                        
                        // Get discount if any
                        const discountSelect = row.querySelector('.discount-select');
                        const discount = discountSelect ? parseInt(discountSelect.value) : 0;
                        
                        // Calculate original item subtotal and discount amount
                        const itemOriginalSubtotal = quantity * price;
                        originalSubtotal += itemOriginalSubtotal;
                        
                        if (discount > 0) {
                            const discountAmount = itemOriginalSubtotal - total;
                            totalDiscount += discountAmount;
                        }
                        
                        subtotal += total;
                        itemCount += quantity;
                        
                        // Add item to receipt
                        itemsHtml += `
                            <div class="receipt-item">
                                <div class="receipt-item-detail">
                                    <span class="receipt-item-name">${productName}</span>
                                    <span class="receipt-item-total">$${total.toFixed(2)}</span>
                                </div>
                                <div class="receipt-item-meta">
                                    <div class="receipt-item-price">
                                        <span class="receipt-item-qty">${quantity} × $${price.toFixed(2)}</span>
                                        ${discount > 0 ? 
                                            `<span class="receipt-item-discount">-${discount}% ($${((itemOriginalSubtotal * discount) / 100).toFixed(2)})</span>` : 
                                            ''}
                                    </div>
                                    <div class="receipt-item-subtotal">
                                        Subtotal: $${itemOriginalSubtotal.toFixed(2)}
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    itemsHtml = '<div class="receipt-empty">No items in cart</div>';
                }
                
                // Update receipt items
                receiptItemsContainer.innerHTML = itemsHtml;
                
                // Calculate tax (using the current tax rate)
                const taxRate = parseFloat('{{ $currentTaxRate ?? 6.0 }}') / 100;
                const tax = subtotal * taxRate;
                const grandTotal = subtotal + tax;
                
                // Update receipt summary
                let summaryHtml = `
                    <div class="receipt-row">
                        <span>Items Count:</span>
                        <span>${itemCount} item${itemCount !== 1 ? 's' : ''}</span>
                    </div>
                    <div class="receipt-row">
                        <span>Original Subtotal:</span>
                        <span>$${originalSubtotal.toFixed(2)}</span>
                    </div>
                `;
                
                if (totalDiscount > 0) {
                    summaryHtml += `
                        <div class="receipt-row discount-highlight">
                            <span>Total Discount:</span>
                            <span>-$${totalDiscount.toFixed(2)}</span>
                        </div>
                    `;
                }
                
                summaryHtml += `
                    <div class="receipt-row">
                        <span>Subtotal After Discount:</span>
                        <span>$${subtotal.toFixed(2)}</span>
                    </div>
                    <div class="receipt-row">
                        <span>Tax (${(taxRate * 100).toFixed(1)}%):</span>
                        <span>$${tax.toFixed(2)}</span>
                    </div>
                    <div class="receipt-total">
                        <span>GRAND TOTAL:</span>
                        <span>$${grandTotal.toFixed(2)}</span>
                    </div>
                `;
                
                receiptSummaryContainer.innerHTML = summaryHtml;
            }

            if (printReceiptBtn && modal) {
                printReceiptBtn.addEventListener('click', () => {
                    updateReceiptContent(); // Update receipt content when showing modal
                    modal.classList.add('active');
                });
            }

            const closeModal = () => {
                 modal.classList.remove('active');
            };

            if (modalClose) {
                modalClose.addEventListener('click', closeModal);
            }

            if (modalFooterClose) {
                 modalFooterClose.addEventListener('click', closeModal);
            }

            // Close modal when clicking outside
            if (modal) {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        closeModal();
                    }
                });
            }

            // Payment method selection
            const paymentMethods = document.querySelectorAll('.payment-method');
            paymentMethods.forEach(method => {
                method.addEventListener('click', () => {
                    paymentMethods.forEach(m => m.classList.remove('active'));
                    method.classList.add('active');

                    // Update receipt payment method display
                    const receiptPaymentMethodSpan = document.getElementById('receipt-payment-method');
                    if (receiptPaymentMethodSpan) {
                        receiptPaymentMethodSpan.textContent = method.querySelector('span').textContent;
                    }
                });
            });

            // Complete sale button
            const completeSaleBtn = document.getElementById('complete-sale-btn');
            if (completeSaleBtn) {
                completeSaleBtn.addEventListener('click', () => {
                    // Create a confirmation toast instead of using confirm()
                    const confirmationToast = Toast.create({
                        type: 'warning',
                        message: 'Are you sure you want to complete this sale?',
                        duration: 0 // Won't auto-dismiss
                    });
                    
                    // Add custom buttons
                    const toastContent = confirmationToast.querySelector('.toast-content');
                    const btnContainer = document.createElement('div');
                    btnContainer.style.display = 'flex';
                    btnContainer.style.gap = '8px';
                    btnContainer.style.marginTop = '8px';
                    
                    const confirmBtn = document.createElement('button');
                    confirmBtn.textContent = 'Yes, Complete';
                    confirmBtn.style.padding = '4px 8px';
                    confirmBtn.style.background = '#fff';
                    confirmBtn.style.color = '#333';
                    confirmBtn.style.border = 'none';
                    confirmBtn.style.borderRadius = '4px';
                    confirmBtn.style.cursor = 'pointer';
                    
                    const cancelBtn = document.createElement('button');
                    cancelBtn.textContent = 'Cancel';
                    cancelBtn.style.padding = '4px 8px';
                    cancelBtn.style.background = 'rgba(255,255,255,0.3)';
                    cancelBtn.style.color = 'inherit';
                    cancelBtn.style.border = 'none';
                    cancelBtn.style.borderRadius = '4px';
                    cancelBtn.style.cursor = 'pointer';
                    
                    btnContainer.appendChild(confirmBtn);
                    btnContainer.appendChild(cancelBtn);
                    toastContent.appendChild(btnContainer);
                    
                    confirmBtn.addEventListener('click', () => {
                        Toast.dismiss(confirmationToast);
                        
                        // Get the selected payment method
                        const selectedMethod = document.querySelector('.payment-method.active span').textContent;
                        
                        // Show loading toast
                        const loadingToast = Toast.create({
                            type: 'info',
                            message: 'Processing sale...',
                            duration: 0 // Won't auto-dismiss
                        });
                        
                        // Send data to the server
                        fetch('/home/cashier/complete-sale', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                payment_method: selectedMethod,
                                customer_name: '', // Could be added as an input field if needed
                                notes: ''
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Dismiss loading toast
                            Toast.dismiss(loadingToast);
                            
                            if (data.success) {
                                // Show success message with invoice number
                                Toast.success(`Sale completed! Invoice #${data.invoice_number}`);
                                
                                // Update receipt with invoice
                                const receiptInvoiceElem = document.querySelector('.receipt-info div:nth-child(2) span:nth-child(2)');
                                if (receiptInvoiceElem) {
                                    receiptInvoiceElem.textContent = data.invoice_number;
                                }
                                
                                // Display the receipt modal
                                const receiptModal = document.getElementById('receipt-modal');
                                if (receiptModal) {
                                    updateReceiptContent(); // Update receipt content before showing
                                    receiptModal.classList.add('active');
                                }
                                
                                // Clear the cart section
                                const cartItems = document.querySelector('.cart-items');
                                if (cartItems) {
                                    cartItems.innerHTML = `
                                        <div class="cart-header">
                                            <div>Product</div>
                                            <div>Quantity</div>
                                            <div>Unit Price</div>
                                            <div>Discount</div>
                                            <div>Total</div>
                                            <div></div>
                                        </div>
                                        <div class="empty-cart">
                                            <i class="fas fa-shopping-cart"></i>
                                            <p>Your cart is empty</p>
                                            <p class="tip">Search for products to add to your cart</p>
                                        </div>
                                    `;
                                }
                                
                                // Reset the summary card
                                updateCartSummary();
                            } else {
                                // Show error message
                                Toast.error(data.message || 'Error completing sale');
                            }
                        })
                        .catch(error => {
                            // Dismiss loading toast
                            Toast.dismiss(loadingToast);
                            console.error('Error:', error);
                            Toast.error('Failed to process sale. Please try again.');
                        });
                    });
                    
                    cancelBtn.addEventListener('click', () => {
                        Toast.dismiss(confirmationToast);
                    });
                });
            }

            // Add quantity handling - incrementing and decrementing
            const quantityControls = document.querySelectorAll('.cart-quantity');
            quantityControls.forEach(control => {
                const decrementBtn = control.querySelector('.qty-btn:first-child');
                const incrementBtn = control.querySelector('.qty-btn:last-child');
                const qtyValue = control.querySelector('.qty-value');
                const cartRow = control.closest('.cart-row'); // Get parent row

                if (decrementBtn && qtyValue && cartRow) {
                    decrementBtn.addEventListener('click', () => {
                        let currentQty = parseInt(qtyValue.textContent);
                        if (currentQty > 1) {
                            qtyValue.textContent = currentQty - 1;
                            updateItemTotal(cartRow);
                        }
                    });
                }

                if (incrementBtn && qtyValue && cartRow) {
                    incrementBtn.addEventListener('click', () => {
                        let currentQty = parseInt(qtyValue.textContent);
                        qtyValue.textContent = currentQty + 1;
                        updateItemTotal(cartRow);
                    });
                }
            });

            // Remove item from cart
            const removeButtons = document.querySelectorAll('.cart-action');
            removeButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const form = button.querySelector('form');
                    const formData = new FormData(form);
                    
                    fetch('/home/cashier/remove-from-cart', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                    const cartRow = button.closest('.cart-row');
                    if (cartRow) {
                         // Add a class for animation before removal
                        cartRow.style.opacity = '0';
                        cartRow.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
                        cartRow.style.transform = 'translateX(20px)';

                        setTimeout(() => {
                            cartRow.remove();
                                    // If no items left, show empty cart message
                                    const cartItems = document.querySelector('.cart-items');
                                    if (!cartItems.querySelector('.cart-row')) {
                                        cartItems.innerHTML = `
                                            <div class="empty-cart">
                                                <i class="fas fa-shopping-cart"></i>
                                                <p>Your cart is empty</p>
                                                <p class="tip">Search for products to add to your cart</p>
                                            </div>
                                        `;
                                    }
                                    updateCartSummary();
                                }, 300);
                            }
                        } else {
                            Toast.error('Failed to remove item from cart');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Toast.error('Error removing item from cart');
                    });
                });
            });

            // Function to update item total price for a single row
            function updateItemTotal(row) {
                if (!row) return;

                const qtyElement = row.querySelector('.qty-value');
                const priceElement = row.querySelector('.cart-price');
                const totalElement = row.querySelector('.cart-total');

                if (qtyElement && priceElement && totalElement) {
                    const qty = parseInt(qtyElement.textContent);
                    // Remove $ and convert to float
                    const price = parseFloat(priceElement.textContent.replace('$', ''));
                    const total = (qty * price).toFixed(2);

                    totalElement.textContent = `$${total}`;
                    updateCartSummary(); // Update overall summary
                }
            }

            // Function to update cart summary card
            function updateCartSummary() {
                const cartRows = document.querySelectorAll('.cart-row');
                let subtotal = 0;
                let itemCount = 0;
                let totalDiscount = 0;
                let originalSubtotal = 0;

                cartRows.forEach(row => {
                    // Get current total with any discounts applied
                    const totalText = row.querySelector('.cart-total').textContent;
                    const total = parseFloat(totalText.replace('$', ''));
                    subtotal += total;

                    // Get quantity
                    const qtyText = row.querySelector('.qty-value').textContent;
                    const quantity = parseInt(qtyText);
                    itemCount += quantity;
                    
                    // Calculate discount (if any)
                    const discountSelect = row.querySelector('.discount-select');
                    if (discountSelect) {
                        const discountPercent = parseInt(discountSelect.value);
                        if (discountPercent > 0) {
                            const priceText = row.querySelector('.cart-price').textContent;
                            const price = parseFloat(priceText.replace('$', ''));
                            const itemOriginalSubtotal = price * quantity;
                            originalSubtotal += itemOriginalSubtotal;
                            
                            // Calculate discount amount
                            const discountAmount = itemOriginalSubtotal - total;
                            totalDiscount += discountAmount;
                        } else {
                            // No discount for this item
                            const priceText = row.querySelector('.cart-price').textContent;
                            const price = parseFloat(priceText.replace('$', ''));
                            originalSubtotal += price * quantity;
                        }
                    }
                });

                // Update summary card elements
                const subtotalElement = document.querySelector('.summary-row:first-child .summary-value');
                const itemCountElement = document.getElementById('item-count'); // Use ID for item count
                const taxElement = document.querySelector('.summary-row:nth-child(2) .summary-value');
                const grandTotalElement = document.querySelector('.grand-total .summary-value');

                // Update the discount row if discounts are applied
                let discountRow = document.querySelector('.discount-row');
                if (totalDiscount > 0) {
                    if (!discountRow) {
                        // Create discount row if it doesn't exist
                        const cardContent = document.querySelector('.card-content');
                        if (cardContent) {
                            discountRow = document.createElement('div');
                            discountRow.className = 'summary-row discount-row';
                            discountRow.innerHTML = `
                                <div class="summary-label">Total Discount</div>
                                <div class="summary-value">-$${totalDiscount.toFixed(2)}</div>
                            `;
                            // Insert before card-content end
                            cardContent.appendChild(discountRow);
                        }
                    } else {
                        // Update existing discount row
                        const discountValueElement = discountRow.querySelector('.summary-value');
                        if (discountValueElement) {
                            discountValueElement.textContent = `-$${totalDiscount.toFixed(2)}`;
                        }
                        discountRow.style.display = '';
                    }
                } else if (discountRow) {
                    // Hide discount row if no discounts
                    discountRow.style.display = 'none';
                }

                if (subtotalElement) {
                    subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
                }

                if (itemCountElement) {
                    itemCountElement.textContent = itemCount; // Update only the count
                }

                // Update tax (assuming 6%)
                const taxRate = 0.06;
                const tax = subtotal * taxRate;
                if (taxElement) {
                    taxElement.textContent = `$${tax.toFixed(2)}`;
                }

                // Update grand total (subtotal + tax)
                const grandTotal = subtotal + tax;
                if (grandTotalElement) {
                    grandTotalElement.textContent = `$${grandTotal.toFixed(2)}`;
                }
                
                // Update receipt values if receipt modal is visible
                const receiptSubtotalElement = document.getElementById('receipt-subtotal');
                const receiptTaxElement = document.getElementById('receipt-tax');
                const receiptDiscountRow = document.getElementById('receipt-discount-row');
                const receiptDiscountElement = document.getElementById('receipt-discount');
                const receiptGrandTotalElement = document.getElementById('receipt-grand-total');
                
                if (receiptSubtotalElement) {
                    receiptSubtotalElement.textContent = `$${subtotal.toFixed(2)}`;
                }
                
                if (receiptTaxElement) {
                    receiptTaxElement.textContent = `$${tax.toFixed(2)}`;
                }
                
                if (receiptDiscountRow && receiptDiscountElement) {
                    if (totalDiscount > 0) {
                        receiptDiscountElement.textContent = `-$${totalDiscount.toFixed(2)}`;
                        receiptDiscountRow.style.display = 'flex';
                    } else {
                        receiptDiscountRow.style.display = 'none';
                    }
                }
                
                if (receiptGrandTotalElement) {
                    receiptGrandTotalElement.textContent = `$${grandTotal.toFixed(2)}`;
                }
            }

            // Update cart summary on page load
            updateCartSummary();

            // Logout confirmation
            const logoutBtn = document.getElementById('logout-btn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Create a confirmation toast
                    const confirmationToast = Toast.create({
                        type: 'warning',
                        message: 'Are you sure you want to log out?',
                        duration: 0 // Won't auto-dismiss
                    });
                    
                    // Add custom buttons
                    const toastContent = confirmationToast.querySelector('.toast-content');
                    const btnContainer = document.createElement('div');
                    btnContainer.style.display = 'flex';
                    btnContainer.style.gap = '8px';
                    btnContainer.style.marginTop = '8px';
                    
                    const confirmBtn = document.createElement('button');
                    confirmBtn.textContent = 'Yes, Log Out';
                    confirmBtn.style.padding = '4px 8px';
                    confirmBtn.style.background = '#fff';
                    confirmBtn.style.color = '#333';
                    confirmBtn.style.border = 'none';
                    confirmBtn.style.borderRadius = '4px';
                    confirmBtn.style.cursor = 'pointer';
                    
                    const cancelBtn = document.createElement('button');
                    cancelBtn.textContent = 'Cancel';
                    cancelBtn.style.padding = '4px 8px';
                    cancelBtn.style.background = 'rgba(255,255,255,0.3)';
                    cancelBtn.style.color = 'inherit';
                    cancelBtn.style.border = 'none';
                    cancelBtn.style.borderRadius = '4px';
                    cancelBtn.style.cursor = 'pointer';
                    
                    btnContainer.appendChild(confirmBtn);
                    btnContainer.appendChild(cancelBtn);
                    toastContent.appendChild(btnContainer);
                    
                    // Handle confirmation
                    confirmBtn.addEventListener('click', function() {
                        // Proceed with logout
                        window.location.href = logoutBtn.getAttribute('href');
                    });
                    
                    // Handle cancellation
                    cancelBtn.addEventListener('click', function() {
                        Toast.dismiss(confirmationToast);
                    });
                });
            }
        });
    </script>
    
    <!-- Toast Notification System -->
    <script>
        // Toast Notification System
        const Toast = {
            create: function(options) {
                const defaultOptions = {
                    type: 'info', // success, error, warning, info
                    message: '',
                    duration: 0  // Default is no auto-dismiss
                };
                
                const config = {...defaultOptions, ...options};
                
                const toast = document.createElement('div');
                toast.className = `toast toast-${config.type}`;
                
                let iconClass = '';
                switch(config.type) {
                    case 'success':
                        iconClass = 'fa-check-circle';
                        break;
                    case 'error':
                        iconClass = 'fa-exclamation-circle';
                        break;
                    case 'warning':
                        iconClass = 'fa-exclamation-triangle';
                        break;
                    default:
                        iconClass = 'fa-info-circle';
                }
                
                toast.innerHTML = `
                    <div class="toast-icon">
                        <i class="fas ${iconClass}"></i>
                    </div>
                    <div class="toast-content">
                        <p class="toast-message">${config.message}</p>
                    </div>
                    <button class="toast-close">
                        <i class="fas fa-times"></i>
                    </button>
                    ${config.duration > 0 ? `
                    <div class="toast-progress">
                        <div class="toast-progress-bar"></div>
                    </div>
                    ` : ''}
                `;
                
                // Add to the DOM
                const container = document.getElementById('toast-container');
                container.appendChild(toast);
                
                // Close button
                const closeBtn = toast.querySelector('.toast-close');
                closeBtn.addEventListener('click', () => {
                    this.dismiss(toast);
                });
                
                // Animation
                setTimeout(() => {
                    toast.classList.add('active');
                }, 10);
                
                // Auto dismiss only if duration is set
                if (config.duration > 0) {
                    setTimeout(() => {
                        this.dismiss(toast);
                    }, config.duration);
                }
                
                return toast;
            },
            
            dismiss: function(toast) {
                toast.classList.remove('active');
                toast.style.height = `${toast.offsetHeight}px`;
                
                setTimeout(() => {
                    toast.style.height = '0';
                    toast.style.padding = '0';
                    toast.style.margin = '0';
                    
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 300);
            },
            
            success: function(message) {
                return this.create({type: 'success', message, duration: 3000}); // Only success messages auto-dismiss after 3 seconds
            },
            
            error: function(message) {
                return this.create({type: 'error', message});
            },
            
            warning: function(message) {
                return this.create({type: 'warning', message});
            },
            
            info: function(message) {
                return this.create({type: 'info', message});
            }
        };
    </script>
    
    <!-- Category Quick Search Script has been integrated into the main script above -->
    
</body>
</html>