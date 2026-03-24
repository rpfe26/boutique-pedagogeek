import {Fragment} from '@wordpress/element';
import ThemeContent from './ThemeContent';
import OptionSidebar from './OptionSidebar';

const OptionContent = () => {
    return (
        <Fragment>
            <div className="blur-theme-options-main">
               <div className="option-tab-content-wrap">
                  <ThemeContent/>
               </div>
               <div className="option-sidebar-wrap">
                  <OptionSidebar />
               </div>
            </div>
        </Fragment>
    );
};
export default OptionContent;