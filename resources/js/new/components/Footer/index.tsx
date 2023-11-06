import React from 'react';
import styles from "./footer.module.css";
import Logo from '@/new/components/logo';

const Footer: React.FC = () => {
  return <footer className={styles.footer}>

    <div className={styles.information}>
        <div className={styles.about}>
            <Logo className={styles.logo}/>

            <div className={styles.description}>
                Yet Another Rhythm Game inspired by beloved classics, delivering an immersive fret rhythm experience.
            </div>
            <div className={styles.contributors}>
                Made with a lot of love by 33 contributors
            </div>
        </div>

        <div className={styles.navigation}>
            <div className={styles.column}>
                <div className={styles.title}>Game</div>
                <ul>
                    <li>Features</li>
                    <li>Download</li>
                    <li>Setlist</li>
                </ul>
            </div>

            <div className={styles.column}>
                <div className={styles.title}>Community</div>
                <ul>
                    <li>News</li>
                </ul>
            </div>

            <div className={styles.column}>
                <div className={styles.title}>Development</div>
                <ul>
                    <li>Nightly Build</li>
                    <li>Contributors</li>
                    <li>Roadmap</li>
                </ul>
            </div>
        </div>
    </div>

    <div className={styles.copyright}>
        <div className={styles.company}>
            <div className={styles.link}>YARC</div>
            <div className={styles.link}>Terms</div>
            <div className={styles.link}>Privacy</div>
            <div className={styles.link}>Cookies</div>
        </div>

        <div className={styles.socials}>
            kkk socials
        </div>
    </div>

  </footer>;
}

export default Footer;