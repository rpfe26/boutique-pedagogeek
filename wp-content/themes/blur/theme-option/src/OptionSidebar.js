import {Fragment} from '@wordpress/element';
import SidebarContent from './SidebarContent';

const OptionSidebar = () => {
    return (
        <Fragment>
            <div className="blur-theme-sidebar-contnet">
               <SidebarContent/>
            </div>
        </Fragment>
    );
};
export default OptionSidebar;