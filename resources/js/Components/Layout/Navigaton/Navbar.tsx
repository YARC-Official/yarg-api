import React, { useState } from 'react';
import PrimaryMenu from '@/Components/Layout/Navigaton/Menu/PrimaryMenu';
import ResponsiveMenu from '@/Components/Layout/Navigaton/Menu/ResponsiveMenu';

export default function Navbar() {


    const [showingNavigationDropdown, setShowingNavigationDropdown] =
        useState(false);

    return (
        <nav className='bg-white border-b border-gray-100 bg-main'>
            {/* <!-- Primary Navigation Menu --> */}
            <PrimaryMenu setShowingNavigationDropdown={setShowingNavigationDropdown}
                         showingNavigationDropdown={showingNavigationDropdown} />

            {/* <!-- Responsive Navigation Menu --> */}
            <ResponsiveMenu setShowingNavigationDropdown={setShowingNavigationDropdown}
                            showingNavigationDropdown={showingNavigationDropdown} />
        </nav>
    );
}
