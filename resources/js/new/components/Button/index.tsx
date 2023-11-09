import React, { PropsWithChildren } from 'react';

import styles from "./button.module.css";

type Props = {
    children?: React.ReactNode;
    color?: "white" | "blue"
}


const Button: React.FC<Props> = ({
  children,
  color = "white",
}: Props) => {
  return <div data-color={color} className={styles.button}>
    {children}
  </div>;
}

export default Button;