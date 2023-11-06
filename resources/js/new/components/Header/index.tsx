import React from 'react';
import styles from "./header.module.css";
import Logo from '../logo';
import { LogIn } from 'lucide-react';

import useTypedPage from '@/Hooks/useTypedPage';
import { User } from '@/types';

const Header: React.FC = () => {
    const page = useTypedPage();

    return <header className={styles.header}>
        <Logo className={styles.logo} />

        <ul>
            <li>Features</li>
            <li>Downloads</li>
            <li>Roadmap</li>
            <li>Community</li>
            <li>News</li>
        </ul>

        {
            page.props.auth.user ? <Logged user={page.props.auth.user}/> : <NotLogged />
        }

    </header>;
}

const Logged: React.FC<{user: User}> = ({user}) => {
    return <div className={styles.user}>
        <div className={styles.username}>{user.name}</div>
        <img 
            src={user.profile_photo_url}
            alt={user.name}
            className={styles.avatar}
        />
    </div>;
}

const NotLogged: React.FC = () => <div className={styles.user}>
    <div>Sign Up</div>
    <div className={styles.button}>
        <LogIn />
        Log In
    </div>
</div>;

export default Header;