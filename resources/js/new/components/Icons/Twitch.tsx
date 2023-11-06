import * as React from "react";
import type { SVGProps } from "react";
const SvgTwitch = (props: SVGProps<SVGSVGElement>) => (
  <svg
    xmlns="http://www.w3.org/2000/svg"
    width={19}
    height={20}
    fill="none"
    {...props}
  >
    <g fill="#fff">
      <path d="M4.246 0 .496 3.571V16.43h4.5V20l3.75-3.571h3L18.496 10V0H4.246Zm12.75 9.286-3 2.857h-3l-2.625 2.5v-2.5H4.996V1.429h12v7.857Z" />
      <path d="M14.746 3.929h-1.5v4.285h1.5V3.93ZM10.621 3.929h-1.5v4.285h1.5V3.93Z" />
    </g>
  </svg>
);
export default SvgTwitch;
