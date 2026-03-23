<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supermarket Management Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/product.css') }}" rel="stylesheet">
    <link href="{{ asset('images/logo.png') }}" rel="icon">
    @stack('styles')
    <style>
        /* Updated CSS Starts Here */

        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            /* Red Panda Color Palette */
            --primary-red: #B94517; /* Main brand rust-red color from logo */
            --primary-red-dark: #8A3211; /* Darker accent for hover states */
            --light-red: #FFF1EC; /* Very light background with red tint */
            --accent-orange: #E66E24; /* Warm orange accent from logo */
            --accent-brown: #70280B; /* Deep brown for contrast */
            --background-light: #FEF8F5; /* Warmer, cream background */
            --surface-white: #FFFFFF; /* Pure white for cards */
            --text-primary: #3D2217; /* Dark brown for text */
            --text-secondary: #7A6158; /* Muted brown for labels/descriptions */
            --border-color: #F0E6E2; /* Light, warm border color */

            /* Payment method colors */
            --color-cash: #D94E33;
            --color-card: #F79E56;
            --color-mobile: #912B10;

            /* Spacing */
            --spacing-unit: 8px;
            --padding-small: calc(var(--spacing-unit) * 1.5); /* 12px */
            --padding-medium: calc(var(--spacing-unit) * 2.5); /* 20px */
            --padding-large: calc(var(--spacing-unit) * 4); /* 32px */

            /* Shadows */
            --shadow-subtle: 0 2px 5px rgba(122, 60, 25, 0.05);
            --shadow-medium: 0 5px 15px rgba(122, 60, 25, 0.08); /* More spread out */

            /* Borders */
            --border-radius-small: 4px;
            --border-radius-medium: 8px;
            --border-radius-large: 12px;

            /* Transitions */
            --transition-duration: 0.3s;
            --transition-ease: ease-in-out;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--background-light);
            color: var(--text-primary);
            display: flex;
            min-height: 100vh;
            line-height: 1.6; /* Improve readability */
        }

        /* Sidebar */
        .sidebar {
            width: 260px; /* Slightly wider */
            background: var(--surface-white); /* Solid white background */
            box-shadow: var(--shadow-medium); /* More prominent shadow */
            padding: var(--padding-medium) 0;
            display: flex;
            flex-direction: column;
            transition: width var(--transition-duration) var(--transition-ease);
            z-index: 10;
            flex-shrink: 0; /* Prevent shrinking */
            position: fixed; /* Make sidebar fixed */
            height: 100vh; /* Full viewport height */
            left: 0;
            top: 0;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            padding: 0 var(--padding-medium) var(--padding-medium);
            margin-bottom: var(--padding-medium);
            border-bottom: 1px solid var(--border-color); /* Soft border */
        }

        .sidebar-logo i {
            font-size: 28px; /* Larger icon */
            color: var(--primary-red);
            margin-right: var(--spacing-unit);
        }

        .sidebar-logo h2 {
            color: var(--text-primary); /* Use text color, not red */
            font-weight: 700; /* Bolder */
            font-size: 20px;
        }

        .sidebar-logo-image {
            width: 32px;
            height: 32px;
            margin-right: var(--spacing-unit);
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            flex: 1;
            padding: 0 var(--spacing-unit); /* Padding for items */
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: var(--padding-small) var(--spacing-unit);
            margin-bottom: var(--spacing-unit);
            color: var(--text-secondary);
            text-decoration: none;
            transition: all var(--transition-duration) var(--transition-ease);
            border-radius: var(--border-radius-small); /* Rounded corners for items */
        }

        .menu-item i {
            font-size: 20px; /* Slightly larger icons */
            width: 30px; /* Fixed width for alignment */
            text-align: center;
            margin-right: var(--spacing-unit);
            transition: color var(--transition-duration) var(--transition-ease);
        }

        .menu-item-label {
            font-size: 15px;
            font-weight: 500;
            white-space: nowrap; /* Prevent wrapping */
            overflow: hidden;
            text-overflow: ellipsis; /* Add ellipsis for long labels */
        }

        .menu-item:hover {
            background-color: var(--light-red);
            color: var(--primary-red-dark); /* Darker red on hover */
        }

        .menu-item.active {
            background-color: var(--light-red);
            color: var(--primary-red-dark);
            font-weight: 600;
            position: relative; /* For the active indicator line */
        }

        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 80%; /* Indicator height */
            width: 4px; /* Indicator thickness */
            background-color: var(--primary-red);
            border-radius: 0 var(--border-radius-small) var(--border-radius-small) 0; /* Rounded end */
        }

        .sidebar-footer {
            padding: var(--padding-medium);
            border-top: 1px solid var(--border-color);
            font-size: 11px;
            color: var(--text-secondary);
            text-align: center;
        }

        /* Main Container */
        .main-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto; /* Allow content scrolling */
            overflow-x: hidden; /* Prevent horizontal scrolling */
            margin-left: 260px; /* Add margin to account for fixed sidebar */
        }

        /* Top Bar */
        .topbar {
            background-color: var(--surface-white);
            box-shadow: var(--shadow-subtle); /* Softer shadow */
            padding: var(--padding-small) var(--padding-large); /* More padding */
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 5;
            flex-shrink: 0; /* Prevent shrinking */
            position: fixed; /* Make topbar fixed */
            top: 0;
            right: 0;
            left: 260px; /* Account for sidebar width */
            height: 70px; /* Fixed height for topbar */
        }

        .page-title {
            font-size: 22px; /* Larger title */
            font-weight: 700;
            color: var(--text-primary);
        }

        .topbar-right {
            display: flex;
            align-items: center;
        }

        /* Language Selector Styles */
        .language-selector {
            margin-right: var(--padding-medium);
            display: flex;
            align-items: center;
        }

        .lang-link {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 8px;
            transition: all var(--transition-duration) var(--transition-ease);
        }

        .lang-link.active {
            color: var(--primary-red) !important;
            font-weight: bold;
            background-color: var(--light-red);
        }

        .lang-link:hover {
            background-color: var(--light-red);
        }

        .language-select {
            appearance: none;
            background-color: var(--background-light);
            border: 1px solid var(--border-color);
            border-radius: 25px;
            padding: var(--spacing-unit) calc(var(--spacing-unit) * 2);
            font-size: 15px;
            color: var(--text-primary);
            cursor: pointer;
            padding-right: calc(var(--spacing-unit) * 4);
        }

        .language-selector::after {
            content: '\f0d7';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            pointer-events: none;
        }

        .language-selector select:focus {
            border-color: var(--primary-red);
            box-shadow: 0 0 0 0.2rem rgba(185, 69, 23, 0.25);
            outline: none;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background-color: var(--background-light); /* Use light background */
            border: 1px solid var(--border-color); /* Subtle border */
            border-radius: 25px; /* More rounded pill shape */
            padding: var(--spacing-unit) calc(var(--spacing-unit) * 2); /* Padding */
            margin-right: var(--padding-medium);
            transition: all var(--transition-duration) var(--transition-ease);
        }

        .search-bar i {
            color: var(--text-secondary);
            margin-right: var(--spacing-unit);
            font-size: 16px;
        }

        .search-bar input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 15px;
            width: 250px; /* Wider search input */
            color: var(--text-primary);
        }

        .search-bar:focus-within {
            border-color: var(--primary-red); /* Highlight on focus */
            box-shadow: 0 0 0 0.2rem rgba(185, 69, 23, 0.25); /* Subtle focus ring */
        }

        .topbar-icon {
            position: relative;
            margin-left: var(--padding-small);
            cursor: pointer;
            color: var(--text-secondary);
            font-size: 20px; /* Slightly larger icons */
            padding: var(--spacing-unit); /* Add padding for larger click area */
            border-radius: 50%; /* Make hover area round */
            transition: all var(--transition-duration) var(--transition-ease);
        }

        .topbar-icon:hover {
            background-color: var(--background-light);
            color: var(--text-primary);
        }

        .notification-dot {
            position: absolute;
            top: var(--spacing-unit); /* Adjusted position */
            right: var(--spacing-unit); /* Adjusted position */
            width: 7px; /* Slightly smaller dot */
            height: 7px;
            background-color: var(--accent-orange);
            border-radius: 50%;
            border: 1.5px solid var(--surface-white); /* White border around dot */
        }

        .avatar {
            width: 40px; /* Larger avatar */
            height: 40px;
            border-radius: 50%;
            margin-left: var(--padding-small);
            background-color: var(--light-red);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-red-dark);
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            border: 2px solid var(--primary-red); /* Subtle red border */
            transition: all var(--transition-duration) var(--transition-ease);
        }

        .avatar:hover {
            opacity: 0.9;
            transform: scale(1.05);
        }

        /* Content Area */
        .content {
            padding: var(--padding-large); /* Increased padding */
            flex: 1;
            margin-top: 70px; /* Add margin to account for fixed topbar */
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); /* Adjusted min width */
            gap: var(--padding-medium); /* Increased gap */
            margin-bottom: var(--padding-large); /* Increased margin */
        }

        .stat-card {
            background: var(--surface-white);
            border-radius: var(--border-radius-medium);
            padding: var(--padding-medium);
            box-shadow: var(--shadow-subtle); /* Subtle shadow */
            display: flex;
            flex-direction: column;
            transition: transform var(--transition-duration) var(--transition-ease), box-shadow var(--transition-duration) var(--transition-ease);
        }

        .stat-card:hover {
            transform: translateY(-5px); /* Lift effect on hover */
            box-shadow: var(--shadow-medium); /* More prominent shadow on hover */
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: var(--padding-small); /* Adjusted margin */
        }

        .stat-title {
            font-size: 15px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .stat-icon {
            width: 44px; /* Slightly larger icon container */
            height: 44px;
            border-radius: var(--border-radius-small);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px; /* Larger icon */
            opacity: 0.8; /* Slightly less opaque */
        }

        .stat-icon.sales {
            background-color: rgba(185, 69, 23, 0.15); /* Primary Red with opacity */
            color: var(--primary-red-dark);
        }

        .stat-icon.products {
            background-color: rgba(33, 150, 243, 0.15); /* Accent Blue with opacity */
            color: var(--accent-brown);
        }

        .stat-icon.alerts {
            background-color: rgba(255, 152, 0, 0.15); /* Accent Orange with opacity */
            color: var(--accent-orange);
        }

        .stat-icon.revenue {
            background-color: rgba(56, 142, 60, 0.15); /* Primary Dark Red with opacity */
            color: var(--primary-red-dark);
        }

        .stat-value {
            font-size: 28px; /* Larger value */
            font-weight: 700; /* Bolder */
            margin-bottom: var(--spacing-unit);
            color: var(--text-primary);
        }

        .stat-change {
            font-size: 13px;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .stat-change i {
            margin-right: var(--spacing-unit);
            font-size: 11px;
        }

        .change-positive {
            color: var(--primary-red-dark);
        }

        .change-negative {
            color: var(--accent-orange);
        }

        /* Charts */
        .charts-container {
            display: grid;
            grid-template-columns: 2fr 1fr; /* Maintain ratio */
            gap: var(--padding-medium); /* Increased gap */
            margin-bottom: var(--padding-large); /* Increased margin */
        }

        .chart-card {
            background: var(--surface-white);
            border-radius: var(--border-radius-medium);
            padding: var(--padding-medium);
            box-shadow: var(--shadow-subtle);
        }

        .chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: var(--padding-medium);
            flex-wrap: wrap; /* Allow wrapping on smaller screens */
            gap: var(--spacing-unit); /* Gap between title and actions */
        }

        .chart-title {
            font-size: 18px; /* Slightly larger title */
            font-weight: 700;
            color: var(--text-primary);
        }

        .chart-actions {
            display: flex;
            align-items: center;
            gap: var(--spacing-unit); /* Gap between period buttons */
        }

        .chart-period {
            font-size: 13px;
            padding: var(--spacing-unit) calc(var(--spacing-unit) * 1.5);
            background-color: var(--background-light);
            border-radius: 15px;
            cursor: pointer;
            color: var(--text-secondary);
            font-weight: 500;
            transition: all var(--transition-duration) var(--transition-ease);
            white-space: nowrap;
        }

        .chart-period:hover {
            background-color: rgba(217, 78, 51, 0.1);
            color: #D94E33;
        }

        .chart-period.active {
            background-color: #D94E33;
            color: var(--surface-white);
            box-shadow: 0 2px 8px rgba(217, 78, 51, 0.3);
        }

        .chart-container {
            height: 280px; /* Slightly taller chart area */
            position: relative;
        }

        /* Chart Placeholder Improvements */
        .chart-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 241, 236, 0.5) 0%, rgba(217, 78, 51, 0.1) 100%);
            border-radius: var(--border-radius-medium);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: flex-end;
            padding: var(--spacing-unit);
        }

        .chart-line {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 80%;
            background: linear-gradient(180deg, rgba(217, 78, 51, 0.8) 0%, rgba(145, 43, 16, 0.1) 100%);
            clip-path: polygon(0 100%, 5% 90%, 10% 92%, 15% 80%, 20% 85%, 25% 70%, 30% 78%, 35% 65%, 40% 70%, 45% 60%, 50% 65%, 55% 55%, 60% 58%, 65% 50%, 70% 53%, 75% 45%, 80% 48%, 85% 40%, 90% 43%, 95% 35%, 100% 38%, 100% 100%, 0 100%);
            opacity: 0.9;
        }

        /* Donut chart placeholder improvements */
        .donut-placeholder {
            position: relative;
            width: 180px; /* Larger donut */
            height: 180px;
            border-radius: 50%;
            background: conic-gradient(
                #D94E33 0% 60%,
                #F79E56 60% 85%,
                #912B10 85% 100%
            );
            margin: 0 auto;
            box-shadow: var(--shadow-subtle); /* Subtle shadow on donut */
        }

        .donut-hole {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100px; /* Larger hole */
            height: 100px;
            background-color: var(--surface-white);
            border-radius: 50%;
        }

        .category-legend {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: var(--padding-medium);
            gap: var(--padding-small); /* Smaller gap in legend */
            font-size: 13px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            color: var(--text-secondary);
        }

        .legend-color {
            width: 14px; /* Larger color square */
            height: 14px;
            border-radius: var(--border-radius-small);
            margin-right: var(--spacing-unit);
        }

        .legend-red {
            background-color: #D94E33;
        }

        .legend-orange {
            background-color: #F79E56;
        }

        .legend-brown {
            background-color: #912B10;
        }


        /* Tables */
        .tables-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: var(--padding-medium);
        }

        .table-card {
            background: var(--surface-white);
            border-radius: var(--border-radius-medium);
            padding: var(--padding-medium);
            box-shadow: var(--shadow-subtle);
        }

        .table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: var(--padding-medium);
            flex-wrap: wrap;
            gap: var(--spacing-unit);
        }

        .table-title {
            font-size: 18px; /* Slightly larger title */
            font-weight: 700;
            color: var(--text-primary);
        }

        .view-all {
            font-size: 13px;
            color: #D94E33;
            cursor: pointer;
            display: flex;
            align-items: center;
            font-weight: 500;
            transition: color var(--transition-duration) var(--transition-ease);
        }

        .view-all:hover {
            color: #F79E56;
        }

        .view-all i {
            margin-left: var(--spacing-unit);
            font-size: 10px;
        }

        .table-content {
            width: 100%;
            border-collapse: collapse;
        }

        .table-content th {
            text-align: left;
            padding: var(--spacing-unit) var(--spacing-unit); /* Adjusted padding */
            font-size: 12px;
            font-weight: 600; /* Slightly bolder header */
            color: var(--text-secondary);
            border-bottom: 1px solid var(--border-color); /* Soft border */
        }

        .table-content td {
            padding: var(--padding-small) var(--spacing-unit); /* Adjusted padding */
            font-size: 14px;
            color: var(--text-primary);
            border-bottom: 1px solid var(--background-light); /* Lighter border for rows */
        }

        .table-content tbody tr:last-child td {
            border-bottom: none;
        }

        /* Zebra striping */
        .table-content tbody tr:nth-child(even) {
            background-color: var(--background-light); /* Light background for even rows */
        }


        .product-name {
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .product-image {
            width: 36px; /* Larger product image placeholder */
            height: 36px;
            border-radius: var(--border-radius-small);
            background-color: var(--light-red); /* Redish background */
            margin-right: var(--spacing-unit);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-red-dark); /* Dark red icon */
            font-size: 16px;
            flex-shrink: 0; /* Prevent shrinking */
        }

        .status {
            padding: 4px 10px; /* Adjusted padding */
            border-radius: 15px; /* More rounded pill shape */
            font-size: 11px; /* Slightly smaller status text */
            font-weight: 600;
            text-transform: uppercase; /* Uppercase status */
        }

        .status.low {
            background-color: rgba(255, 152, 0, 0.15);
            color: var(--accent-orange);
        }

        .status.medium {
            background-color: rgba(255, 193, 7, 0.15);
            color: #FFB300; /* Slightly darker yellow */
        }

        .status.high {
            background-color: rgba(76, 175, 80, 0.15);
            color: var(--primary-red-dark);
        }


        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .sidebar {
                width: 200px; /* Make sidebar narrower on medium screens */
            }
            .sidebar-logo h2 {
                font-size: 16px;
            }
            .menu-item-label {
                font-size: 13px;
            }
            .sidebar-logo i {
                font-size: 24px;
            }
            .main-container {
                margin-left: 200px; /* Adjust margin for narrower sidebar */
            }
            .search-bar input {
                width: 180px;
            }
            .charts-container {
                grid-template-columns: 1fr; /* Stack charts vertically */
            }
            .topbar {
                left: 200px; /* Adjust topbar position for narrower sidebar */
            }
        }


        @media (max-width: 992px) {
            .sidebar {
                width: 80px; /* Collapse sidebar to icon-only */
                position: fixed;
                height: 100%;
            }

            .sidebar-logo h2,
            .menu-item-label,
            .sidebar-footer {
                display: none;
            }

            .sidebar-logo {
                justify-content: center;
                padding: var(--padding-medium) 0;
            }

            .sidebar-logo i {
                margin-right: 0;
                font-size: 28px; /* Keep icon size */
            }

            .sidebar-menu {
                padding: 0; /* Remove padding from menu container */
            }

            .menu-item {
                justify-content: center;
                padding: var(--padding-medium) 0; /* Center icons */
                margin-bottom: 0; /* Remove bottom margin */
                border-radius: 0; /* Remove border radius when collapsed */
                border-left: 3px solid transparent; /* Active indicator when collapsed */
            }
             .menu-item.active::before { /* Move active indicator to the left */
                left: 0;
                width: 4px;
                height: 100%;
                top: 0;
                transform: none;
                border-radius: 0;
            }

            .menu-item i {
                margin-right: 0;
                font-size: 24px; /* Adjust icon size */
                width: auto; /* Auto width */
            }

            .main-container {
                margin-left: 80px; /* Push main content right */
            }

            .topbar {
                left: 80px; /* Adjust topbar position for collapsed sidebar */
            }

            .page-title {
                font-size: 20px;
            }

            .search-bar input {
                 width: 100px; /* Make search narrower */
            }

            .charts-container {
                grid-template-columns: 1fr; /* Stack charts vertically */
            }
        }


        @media (max-width: 768px) {
            .topbar-right {
                flex-grow: 1; /* Allow icons to take space */
                justify-content: flex-end; /* Push icons to the right */
            }
            .search-bar {
                 width: 100%; /* Full width search on smaller tablets */
                 margin-right: var(--spacing-unit);
                 padding: var(--spacing-unit) calc(var(--spacing-unit) * 1.5);
            }
            .search-bar input {
                flex-grow: 1; /* Allow input to fill space */
                width: auto; /* Override fixed width */
            }

            .stats-container {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); /* Smaller card minimum */
                gap: var(--padding-small);
            }

            .tables-container {
                grid-template-columns: 1fr; /* Stack tables */
                gap: var(--padding-small);
            }

             .content {
                padding: var(--padding-medium); /* Reduced padding */
            }

            .stat-value {
                font-size: 22px; /* Smaller stat values */
            }
             .stat-header {
                margin-bottom: var(--spacing-unit);
            }
             .stat-title {
                font-size: 13px;
             }
             .stat-icon {
                width: 36px;
                height: 36px;
                font-size: 16px;
             }
             .stat-change {
                font-size: 11px;
             }
              .table-content th, .table-content td {
                padding: var(--spacing-unit); /* Tighter table padding */
              }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 60px; /* Even narrower sidebar */
            }
             .main-container {
                margin-left: 60px; /* Push main content right */
            }
             .topbar {
                left: 60px; /* Adjust topbar position for narrower sidebar */
             }
            .page-title {
                display: none; /* Hide page title to save space */
            }
            .search-bar {
                display: none; /* Hide search bar on smallest screens (often replaced by a search icon expanding) */
            }
            .topbar-icon {
                margin-left: var(--spacing-unit);
                font-size: 18px;
            }
             .avatar {
                width: 32px;
                height: 32px;
                font-size: 14px;
             }

            .content {
                padding: var(--padding-small); /* Minimal padding */
            }

            .stats-container {
                gap: var(--spacing-unit); /* Minimal gap */
                margin-bottom: var(--padding-medium);
            }
            .stat-card {
                padding: var(--padding-small); /* Tighter card padding */
            }
             .stat-value {
                font-size: 20px;
             }

             .charts-container {
                gap: var(--spacing-unit);
                margin-bottom: var(--padding-medium);
             }
             .chart-card {
                padding: var(--padding-small);
             }
              .chart-header {
                margin-bottom: var(--padding-small);
                flex-direction: column; /* Stack header elements */
                align-items: flex-start;
              }
               .chart-actions {
                 margin-top: var(--spacing-unit);
               }
               .chart-period {
                 padding: 4px 8px;
               }
               .chart-container {
                 height: 200px; /* Shorter charts */
               }
                .donut-placeholder {
                    width: 140px;
                    height: 140px;
                }
                .donut-hole {
                    width: 70px;
                    height: 70px;
                }
                .category-legend {
                    font-size: 11px;
                    gap: var(--spacing-unit);
                }


             .tables-container {
                gap: var(--spacing-unit);
             }
              .table-card {
                padding: var(--padding-small);
              }
              .table-header {
                 flex-direction: column; /* Stack header elements */
                align-items: flex-start;
                margin-bottom: var(--padding-small);
              }
               .view-all {
                margin-top: var(--spacing-unit);
               }

              .table-content th, .table-content td {
                 padding: var(--spacing-unit);
                 font-size: 13px;
               }
               .product-image {
                width: 28px;
                height: 28px;
                font-size: 14px;
               }
                .status {
                    padding: 3px 8px;
                     font-size: 10px;
                }
        }

        /* Updated CSS Ends Here */

        /* Data Tables Styling */
        .data-section {
            margin-top: 25px;
            background-color: var(--surface-white);
            border-radius: var(--border-radius-medium);
            box-shadow: var(--shadow-subtle);
            overflow: hidden;
            margin-bottom: var(--padding-medium);
        }
        
        .section-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .section-header h2 {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }
        
        .data-table-container {
            overflow-x: auto;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table th, .data-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        
        .data-table th {
            background-color: var(--light-red);
            color: var(--text-primary);
            font-weight: 600;
        }
        
        .data-table tbody tr:hover {
            background-color: rgba(185, 69, 23, 0.05);
        }
        
        /* Status Indicators */
        .status-active, .performance-high, .stock-ok {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            background-color: rgba(185, 69, 23, 0.15);
            color: var(--primary-red-dark);
        }
        
        .status-inactive, .performance-low, .stock-critical {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            background-color: rgba(244, 67, 54, 0.15);
            color: #d32f2f;
        }
        
        .performance-medium, .stock-low {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            background-color: rgba(255, 152, 0, 0.15);
            color: #ef6c00;
        }

        /* User Profile */
        .user-profile {
            display: flex;
            align-items: center;
            gap: var(--spacing-unit);
            padding: var(--spacing-unit) var(--padding-small);
            background: var(--background-light);
            border-radius: 50px;
            box-shadow: var(--shadow-subtle);
            transition: all var(--transition-duration) var(--transition-ease);
            margin-left: var(--padding-small);
            position: relative;
        }
        
        .user-profile:hover {
            background: var(--light-red);
            transform: translateY(-1px);
            box-shadow: var(--shadow-medium);
        }
        
        .logout-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background-color: var(--light-red);
            color: var(--primary-red);
            transition: all 0.3s ease;
            margin-left: 5px;
            border: 1px solid transparent;
        }
        
        .logout-button:hover {
            background-color: var(--primary-red);
            color: white;
            transform: rotate(360deg);
            box-shadow: 0 0 10px rgba(231, 76, 60, 0.3);
        }
        
        .logout-button i {
            font-size: 16px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .user-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 14px;
            white-space: nowrap;
        }

        .user-role {
            font-size: 12px;
            color: var(--text-secondary);
            text-transform: capitalize;
        }

        @media (max-width: 768px) {
            .user-profile {
                padding: calc(var(--spacing-unit) / 2);
            }
            
            .user-info {
                display: none;
            }
            
            .avatar {
                margin-left: 0;
            }
            
            .logout-button {
                margin-left: 2px;
                width: 30px;
                height: 30px;
            }
            
            .logout-button i {
                font-size: 14px;
            }
        }

        .chart-labels {
            display: flex;
            justify-content: space-between;
            padding: 1rem;
            border-top: 1px solid var(--border-color);
            margin-top: 1rem;
        }

        .chart-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 0.875rem;
        }

        .chart-label span:first-child {
            color: var(--text-secondary);
            margin-bottom: 0.25rem;
        }

        .chart-label span:last-child {
            font-weight: 600;
            color: var(--text-primary);
        }

        .legend-cash { background-color: var(--color-cash); }
        .legend-card { background-color: var(--color-card); }
        .legend-mobile { background-color: var(--color-mobile); }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-actions {
            display: flex;
            align-items: center;
            gap: var(--spacing-unit);
        }

        .role-tables {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--padding-medium);
            margin-top: var(--padding-small);
        }

        .role-section {
            background: var(--surface-white);
            border-radius: var(--border-radius-medium);
            padding: var(--padding-medium);
            box-shadow: var(--shadow-subtle);
        }

        .role-section h3 {
            color: var(--text-primary);
            font-size: 1rem;
            margin-bottom: var(--padding-small);
            padding-bottom: var(--spacing-unit);
            border-bottom: 1px solid var(--border-color);
        }

        .role-section .data-table {
            margin-top: 0;
        }

        .role-section .data-table th,
        .role-section .data-table td {
            padding: var(--spacing-unit) var(--padding-small);
            font-size: 0.875rem;
        }

        .role-section .data-table td:first-child {
            color: var(--text-secondary);
            font-family: monospace;
        }

        @media (max-width: 768px) {
            .role-tables {
                grid-template-columns: 1fr;
            }
        }

        .language-submit {
            display: inline-block;
            margin-left: 8px;
            padding: 8px 16px;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            background-color: var(--background-light);
            color: var(--text-primary);
            font-size: 14px;
            cursor: pointer;
            transition: all var(--transition-duration) var(--transition-ease);
        }

        .language-submit:hover {
            border-color: var(--primary-red);
            background-color: var(--light-red);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <a href="{{ url('master/index') }}" style="text-decoration: none; display: flex; align-items: center;">
                <img src="{{ asset('images/logo.png') }}" alt="Red Panda Logo" class="sidebar-logo-image">
                <h2>Red Panda</h2>
            </a>
        </div>
        <div class="sidebar-menu">
            <a href="{{ url('master/dashboard') }}" class="menu-item {{ Request::is('master/dashboard') || Request::is('master/index') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i>
                <span class="menu-item-label">{{ __('messages.dashboard') }}</span>
            </a>
            <a href="{{ url('master/product') }}" class="menu-item {{ Request::is('master/product') ? 'active' : '' }}">
                <i class="fas fa-box"></i>
                <span class="menu-item-label">{{ __('messages.products') }}</span>
            </a>
            <a href="{{ url('master/sale') }}" class="menu-item {{ Request::is('master/sale') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span class="menu-item-label">{{ __('messages.sales') }}</span>
            </a>
            <a href="{{ url('master/employees') }}" class="menu-item {{ Request::is('master/employees') ? 'active' : '' }}">
                <i class="fas fa-id-card"></i>
                <span class="menu-item-label">{{ __('messages.employees') }}</span>
            </a>
            <a href="{{ url('master/report') }}" class="menu-item {{ Request::is('master/report') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                <span class="menu-item-label">{{ __('messages.reports') }}</span>
            </a>
            <a href="{{ url('master/sitting') }}" class="menu-item {{ Request::is('master/sitting') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                <span class="menu-item-label">{{ __('messages.system_settings') }}</span>
            </a>
        </div>
        <div class="sidebar-footer">
            © 2025 FreshMart
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Top Bar -->
        <div class="topbar">
            <h1 class="page-title">{{ Request::is('master/index') || Request::is('master/dashboard') ? __('messages.dashboard') : (isset($title) ? __($title) : __('messages.dashboard')) }}</h1>
            <div class="topbar-right">
                <!-- No language selector -->

                <div class="user-profile">
                    <div class="avatar">
                        @if(Auth::user()->profile_image)
                            <img src="{{ asset('images/profiles/' . Auth::user()->profile_image) }}" alt="{{ Auth::user()->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        @else
                            {{ substr(Auth::user()->name, 0, 1) }}
                        @endif
                    </div>
                    <div class="user-info">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <span class="user-role">{{ ucfirst(Auth::user()->role) }}</span>
                    </div>
                    <a href="{{ route('logout') }}" class="logout-button" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content">
            @if(isset($contentTitle))
                <h1 class="content-title">{{ $contentTitle }}</h1>
            @endif
            
            @yield('content')
            @yield('styles')
            
            <!-- Dashboard Content -->
            @if(Request::is('master/index') || Request::is('master/dashboard'))
                <!-- Stats Cards -->
                <div class="stats-container">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-title">{{ __('messages.today_sales') }}</div>
                            <div class="stat-icon sales">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="stat-value">${{ number_format($todaySales, 2) }}</div>
                        <div class="stat-change {{ $salesChange >= 0 ? 'change-positive' : 'change-negative' }}">
                            <i class="fas fa-arrow-{{ $salesChange >= 0 ? 'up' : 'down' }}"></i>
                            {{ abs(number_format($salesChange, 1)) }}% {{ __('messages.from_yesterday') }}
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-title">{{ __('messages.total_products') }}</div>
                            <div class="stat-icon products">
                                <i class="fas fa-box"></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ number_format($totalProducts) }}</div>
                        <div class="stat-change change-positive">
                            <i class="fas fa-arrow-up"></i> +{{ $newProductsToday }} {{ __('messages.new_today') }}
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-title">{{ __('messages.low_stock_alerts') }}</div>
                            <div class="stat-icon alerts">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $lowStockProducts }}</div>
                        <div class="stat-change {{ $lowStockChange > 0 ? 'change-negative' : 'change-positive' }}">
                            <i class="fas fa-arrow-{{ $lowStockChange > 0 ? 'up' : 'down' }}"></i>
                            {{ abs(number_format($lowStockChange, 1)) }}% {{ __('messages.from_last_day') }}
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-title">{{ __('messages.monthly_revenue') }}</div>
                            <div class="stat-icon revenue">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                        <div class="stat-value">${{ number_format($monthlyRevenue, 2) }}</div>
                        <div class="stat-change {{ $revenueChange >= 0 ? 'change-positive' : 'change-negative' }}">
                            <i class="fas fa-arrow-{{ $revenueChange >= 0 ? 'up' : 'down' }}"></i>
                            {{ abs(number_format($revenueChange, 1)) }}% {{ __('messages.from_last_month') }}
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="charts-container">
                    <div class="chart-card">
                        <div class="chart-header">
                            <div class="chart-title">Revenue Overview</div>
                            <div class="chart-actions">
                                <div class="chart-period active">Week</div>
                            </div>
                        </div>
                        <div class="chart-container">
                            <div class="chart-placeholder">
                                <div class="chart-line"></div>
                                <div class="chart-labels">
                                    @foreach($weeklyRevenue as $day)
                                        <div class="chart-label">
                                            <span>{{ $day['date'] }}</span>
                                            <span>${{ number_format($day['total'], 0) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <div class="chart-title">Payment Methods (This Month)</div>
                        </div>
                        <div class="chart-container">
                            <div class="donut-placeholder" data-payment-stats='@json($paymentStats)'>
                                <div class="donut-hole"></div>
                            </div>
                            <div class="category-legend">
                                @foreach($paymentStats as $stat)
                                    <div class="legend-item">
                                        <div class="legend-color legend-{{ strtolower($stat['method']) }}"></div>
                                        <span>{{ $stat['method'] }} ({{ $stat['percentage'] }}%)</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tables -->
                <div class="tables-container">
                    <div class="table-card">
                        <div class="table-header">
                            <div class="table-title">{{ __('messages.low_stock_items') }}</div>
                            <a href="{{ url('master/product') }}" class="view-all">{{ __('messages.view_all') }} <i class="fas fa-chevron-right"></i></a>
                        </div>
                        <table class="table-content">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.product') }}</th>
                                    <th>{{ __('messages.category') }}</th>
                                    <th>{{ __('messages.stock') }}</th>
                                    <th>{{ __('messages.status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowStockItems as $item)
                                <tr>
                                    <td>
                                        <div class="product-name">
                                            <div class="product-image">
                                                <i class="fas fa-box"></i>
                                            </div>
                                            <span>{{ $item->product_name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $item->category }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>
                                        <span class="status {{ $item->qty <= 30 ? 'low' : 'medium' }}">
                                            {{ $item->qty <= 30 ? __('messages.critical') : __('messages.low') }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">{{ __('messages.no_items') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="table-card">
                        <div class="table-header">
                            <div class="table-title">{{ __('messages.recent_sales') }}</div>
                            <a href="{{ url('master/sale') }}" class="view-all">{{ __('messages.view_all') }} <i class="fas fa-chevron-right"></i></a>
                        </div>
                        <table class="table-content">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.order_id') }}</th>
                                    <th>{{ __('messages.cashier') }}</th>
                                    <th>{{ __('messages.amount') }}</th>
                                    <th>{{ __('messages.date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentSales as $sale)
                                <tr>
                                    <td>{{ $sale->invoice_number }}</td>
                                    <td>{{ $sale->cashier_name }}</td>
                                    <td>${{ number_format($sale->grand_total, 2) }}</td>
                                    <td>{{ $sale->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">{{ __('messages.no_sales') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Employee Management Section -->
                <div class="data-section">
                    <div class="section-header">
                        <h2>{{ __('messages.employee_management') }}</h2>
                        <div class="section-actions">
                            <a href="{{ url('master/employees') }}" class="view-all">{{ __('messages.view_all') }} <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                    <div class="data-table-container">
                        <div class="role-tables">
                            <!-- Managers -->
                            <div class="role-section">
                                <h3>{{ __('messages.managers') }} ({{ $staffByRole['managers']->count() }})</h3>
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.id') }}</th>
                                            <th>{{ __('messages.name') }}</th>
                                            <th>{{ __('messages.email') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($staffByRole['managers'] as $manager)
                                        <tr>
                                            <td>#{{ $manager->id }}</td>
                                            <td>{{ $manager->name }}</td>
                                            <td>{{ $manager->email }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center">{{ __('messages.no_data') }}</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Cashiers -->
                            <div class="role-section">
                                <h3>{{ __('messages.cashiers') }} ({{ $staffByRole['cashiers']->count() }})</h3>
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.id') }}</th>
                                            <th>{{ __('messages.name') }}</th>
                                            <th>{{ __('messages.email') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($staffByRole['cashiers'] as $cashier)
                                        <tr>
                                            <td>#{{ $cashier->id }}</td>
                                            <td>{{ $cashier->name }}</td>
                                            <td>{{ $cashier->email }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center">{{ __('messages.no_data') }}</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Stock Staff -->
                            <div class="role-section">
                                <h3>{{ __('messages.stock_staff') }} ({{ $staffByRole['stock']->count() }})</h3>
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.id') }}</th>
                                            <th>{{ __('messages.name') }}</th>
                                            <th>{{ __('messages.email') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($staffByRole['stock'] as $staff)
                                        <tr>
                                            <td>#{{ $staff->id }}</td>
                                            <td>{{ $staff->name }}</td>
                                            <td>{{ $staff->email }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center">{{ __('messages.no_data') }}</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cashier Daily Performance Section -->
                <div class="data-section">
                    <div class="section-header">
                        <h2>Cashier Daily Performance</h2>
                    </div>
                    <div class="data-table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Cashier Name</th>
                                    <th>Transactions</th>
                                    <th>Total Sales</th>
                                    <th>Average Sale</th>
                                    <th>Performance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cashierPerformance as $cashier)
                                <tr>
                                    <td>{{ $cashier['name'] }}</td>
                                    <td>{{ $cashier['transactions'] }}</td>
                                    <td>${{ number_format($cashier['total_sales'], 2) }}</td>
                                    <td>${{ number_format($cashier['average_sale'], 2) }}</td>
                                    <td><span class="performance-{{ $cashier['performance'] }}">{{ ucfirst($cashier['performance']) }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No sales data for today</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div> <!-- End of content -->
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Language switcher
            const languageSelect = document.getElementById('languageSelect');
            if (languageSelect) {
                languageSelect.addEventListener('change', function() {
                    const form = document.getElementById('languageForm');
                    if (form) {
                        form.submit();
                    }
                });
            }
            
            // Legacy language selection
            const systemLanguage = document.getElementById('system-language');
            if (systemLanguage) {
                const languageWrapper = document.querySelector('.language-select-wrapper');
                
                function updateLanguageFlag() {
                    const selectedOption = systemLanguage.options[systemLanguage.selectedIndex];
                    const icon = selectedOption.getAttribute('data-icon');
                    
                    // Update flag image
                    if (icon === 'us') {
                        languageWrapper.style.setProperty('--flag-url', 'url(\'https://flagcdn.com/w20/us.png\')');
                    } else if (icon === 'kh') {
                        languageWrapper.style.setProperty('--flag-url', 'url(\'https://flagcdn.com/w20/kh.png\')');
                    }
                }
                
                systemLanguage.addEventListener('change', updateLanguageFlag);
                
                // Set initial flag
                languageWrapper.style.setProperty('--flag-url', 'url(\'https://flagcdn.com/w20/us.png\')');
            }

            // Initialize payment donut chart
            const donut = document.querySelector('.donut-placeholder');
            if (donut) {
                const stats = JSON.parse(donut.dataset.paymentStats || '[]');
                let startAngle = 0;
                const gradientParts = stats.map(stat => {
                    const endAngle = startAngle + (stat.percentage * 3.6);
                    const part = `var(--color-${stat.method.toLowerCase()}) ${startAngle}deg ${endAngle}deg`;
                    startAngle = endAngle;
                    return part;
                });
                donut.style.background = `conic-gradient(${gradientParts.join(', ')})`;
            }
        });
    </script>
    @endpush
</body>
</html>