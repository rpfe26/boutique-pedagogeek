import {Fragment} from '@wordpress/element';
import { __ } from '@wordpress/i18n';

const OptionHeader = () => {
    return (
        <Fragment>
        <div className="blur-theme-options-header">
       
              <div className="th-logo-img">
                        <a target="_blank" href="https://themehunk.com/" > 
                        <span className="logo-image">
                         <img className="logo-img" src={`${wpapi.blurUri}/theme-option/assets/img/logo-themehunk.png`}></img>
                         </span>
                        </a>
              </div> 
             
          <div className="th-option-area">
           <div className="th-option-top-hdr">
              <div className="th-col2">
                    <div className="th-option-heading">
                       <h2>{__( 'Welcome To Blur Theme', 'blur' )}</h2>
                       <p>{__( 'Blur Theme is a Free WooCommerce theme for creating clean and professional shopping stores', 'blur' )}</p>
                    </div>
                    <div className="th-option-detail">
                        <p className="th-version">{__( 'Version 1.2.6', 'blur' )}</p>
                        <span>{__( 'Free', 'blur' )}</span>
                    </div>
              </div>
            </div>

            
          </div>
        </div>
        </Fragment>
    );
  };
  
export default OptionHeader;