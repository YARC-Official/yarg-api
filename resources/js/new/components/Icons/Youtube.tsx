import * as React from "react";
import type { SVGProps } from "react";
const SvgYoutube = (props: SVGProps<SVGSVGElement>) => (
  <svg
    xmlns="http://www.w3.org/2000/svg"
    width={29}
    height={20}
    fill="none"
    {...props}
  >
    <path
      fill="#fff"
      d="M27.902 3.13A3.574 3.574 0 0 0 25.387.597C23.17 0 14.274 0 14.274 0S5.379 0 3.161.598A3.574 3.574 0 0 0 .646 3.13C.052 5.362.052 10.02.052 10.02s0 4.658.594 6.891c.327 1.232 1.291 2.162 2.515 2.49C5.379 20 14.274 20 14.274 20s8.895 0 11.113-.598c1.224-.33 2.188-1.26 2.515-2.49.594-2.234.594-6.892.594-6.892s0-4.658-.594-6.89ZM11.365 14.25V5.79l7.434 4.23-7.434 4.23Z"
    />
  </svg>
);
export default SvgYoutube;
