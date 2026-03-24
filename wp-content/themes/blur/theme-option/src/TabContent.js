import React, { useState, useEffect } from 'react';
import { __ } from '@wordpress/i18n';
import WelcomeContent from './WelcomeContent';
import HelpContent from './HelpContent';
import RecommendedContent from './RecommendedContent';
import FeeProContent from './FeeProContent';

const TabContent = (props) => {
    const [settings, setSettings] = useState({});
    const [activeTab, setActiveTab] = useState('welcome');
    const handleTabClick = (tabName) => {
      setActiveTab(tabName);
    };
  return (
    <div className="blur-options-tab">
    <div className="blur-tabs">
        <button
          className={`tab welcome ${activeTab === 'welcome' ? 'active' : ''}`}
          onClick={() => handleTabClick('welcome')}
        >
         { __( 'Welcome', 'blur' )}
          
        </button>
        <button
          className={`tab recommended ${activeTab === 'recommended' ? 'active' : ''}`}
          onClick={() => handleTabClick('recommended')}
        >
          { __( 'Recommended Plugin', 'blur' )}
        </button>
       
        <button
          className={`tab help ${activeTab === 'help' ? 'active' : ''}`}
          onClick={() => handleTabClick('help')}
        >
          { __( 'Help', 'blur' )}
        </button>
      </div>
      <div className="tab-content">
        {activeTab === 'welcome' && (
          <div className="welcome-tab">
             <WelcomeContent/>
          </div>
        )}
        {activeTab === 'recommended' && (
          <div className="recommended-tab">
            <RecommendedContent/>
          </div>
        )}
       
        {activeTab === 'freevspro' && (
          <div className="freevspro-tab">
            <FeeProContent/>
          </div>
        )}
        {activeTab === 'help' && (
          <div className="help-tab">
           <HelpContent/>
            
          </div>
        )}
      </div>
    </div>
  );
};

export default TabContent;