/**
 * Base layout used by the other layouts
 * @param children
 * @returns {JSX.Element}
 * @constructor
 */
const Layout = ({children}) => {
  return (
    <div id="layout" className={"padding-top-2"}>
      {children}
    </div>
  )
}

export default Layout
