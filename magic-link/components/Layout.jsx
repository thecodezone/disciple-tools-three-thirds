import TopBar from "./TopBar";
import Menu from './Menu'

const Layout = ({children}) => {
  return (
    <div id="layout">
      <TopBar />
      <Menu />
      {children}
    </div>
  )
}

export default Layout
