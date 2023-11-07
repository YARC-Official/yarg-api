import * as React from "react";
import type { SVGProps } from "react";
const SvgX = (props: SVGProps<SVGSVGElement>) => (
  <svg
    xmlns="http://www.w3.org/2000/svg"
    width={24}
    height={20}
    fill="none"
    {...props}
  >
    <path
      fill="#fff"
      d="M18.354 0h3.395l-7.415 8.472L23.052 20H16.22l-5.344-6.995L4.754 20H1.37l7.928-9.067L.928 0h7.006l4.83 6.39L18.355 0Zm-1.19 17.97h1.877L6.909 1.927h-2.02L17.165 17.97Z"
    />
  </svg>
);
export default SvgX;
