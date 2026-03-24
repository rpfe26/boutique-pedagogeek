import {Fragment} from '@wordpress/element';
import { __ } from '@wordpress/i18n';

const SidebarContent = () => {
    return (
        <Fragment>
            <div className="sidebar-option-content-wrp">
               <div className="content-box">
                <h3> {__( 'ThemeHunk Premium Themes', 'blur' )}</h3>
                <p>{__( 'ThemeHunk specializes in creating premium WordPress themes and plugins. We offer extensive documentation, video tutorials, and a dedicated support team to help users with any questions or issues they may encounter.', 'blur' )}</p>
                <a href="https://themehunk.com/pro-wordpress-themes/" className="content-link button" target="_blank"> {__( 'View Premium Themes', 'blur' )}</a>
               </div>
               <hr></hr>
               <div className="content-box">
                <h3> {__( 'Leave us a review', 'blur' )}</h3>
                <p>{__( 'We would love to hear your feedback.', 'blur' )}</p>
                <a href="https://wordpress.org/support/theme/blur/reviews/#new-post" className="content-link" target="_blank"> {__( 'Submit review', 'blur' )}</a>
               </div>
               <hr></hr>
               <div className="content-box">
                <h3> {__( 'Video Tutorials', 'blur' )}</h3>
                <p>{__( 'Want a guide? We have video tutorials to walk you through getting started.', 'blur' )}</p>
                <a href="https://www.youtube.com/@ThemeHunk/featured" className="content-link" target="_blank"> {__( 'Watch Videos', 'blur' )}</a>
               </div>
               <hr></hr>
               <div className="content-box">
                <h3> {__( 'Support', 'blur' )}</h3>
                <p>{__( 'Have a question, we are happy to help! Get in touch with our support team.', 'blur' )}</p>
                <a href="https://themehunk.com/contact-us/" className="content-link" target="_blank"> {__( 'Submit a Ticket', 'blur' )}</a>
               </div>
            </div>
        </Fragment>
    );
};

export default SidebarContent;