import { Link } from '@inertiajs/react';
import classNames from 'classnames';
import React, { PropsWithChildren } from 'react';

type Props =
  | {
      as: 'button';
      active?: boolean;
      href?: undefined;
    }
  | {
      active?: boolean;
      href: string;
    };

export default function ResponsiveNavLink({
  active,
  href,
  children,
  ...props
}: PropsWithChildren<Props>) {
  const classes = active
    ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-left text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out'
    : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out';

  return (
    <div>
      {'as' in props && props.as === 'button' ? (
        <button className={classNames('w-full text-left', classes)}>
          {children}
        </button>
      ) : (
        <Link href={href || ''} className={classes}>
          {children}
        </Link>
      )}
    </div>
  );
}
