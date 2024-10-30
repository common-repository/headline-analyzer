(()=>{"use strict";var e={n:t=>{var n=t&&t.__esModule?()=>t.default:()=>t;return e.d(n,{a:n}),n},d:(t,n)=>{for(var i in n)e.o(n,i)&&!e.o(t,i)&&Object.defineProperty(t,i,{enumerable:!0,get:n[i]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t)};const t=window.wp.element,n=window.wp.plugins,i=window.wp.data,o=()=>window?.coscheduleHeadlineStudio?.hs_embed_token,a="https://headlines.coschedule.com";function s(e){window.addEventListener("message",(async t=>{try{JSON.stringify(t,null,0),await e(t)}catch(e){JSON.stringify(t,null,0),e&&e.stack}}))}const l=window.wp.apiFetch;var d=e.n(l);const r=Object.freeze({headlineStudioHasMounted:"headlineStudioHasMounted"}),c={[r.headlineStudioHasMounted]:!1},u="headline-studio-store",h={reducer:function(){let e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:c,t=arguments.length>1?arguments[1]:void 0;switch(t.type){case"SET_HEADLINE_STUDIO_HAS_MOUNTED":return{...e,[r.headlineStudioHasMounted]:t.hasMounted};case"START_RESOLUTION":case"FINISH_RESOLUTION":return e;default:return console.log(`Unknown Action Type - ${t.type}`),e}},actions:{setHeadlineStudioHasMounted:()=>({type:"SET_HEADLINE_STUDIO_HAS_MOUNTED",hasMounted:!0})},selectors:{getHeadlineStudioHasMounted:e=>e[r.headlineStudioHasMounted]}},p="cos_headline_score",m="cos_seo_score",g="cos_headline_text",_="cos_last_analyzed_headline",w="last_headline_score",E="last_headline_text",S="cos_headline_has_been_analyzed";function y(){let e,t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};if(n.isClassicEditor)e=window.coscheduleHeadlineStudio?.classicEditorApp?.postId;else{const{id:t}=(0,i.select)("core/editor").getCurrentPost();e=t}try{d()({path:`/cos_headline_studio/v1/set_headline_post_meta/${e}`,method:"POST",data:t})}catch(e){console.log(e)}}function f(){let e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return y(e,t),t.isClassicEditor?null:(0,i.dispatch)("core/editor").editPost({meta:{...e}},t)}function b(e){return(0,i.select)("core/editor").getEditedPostAttribute(e)}function H(){let e=arguments.length>0&&void 0!==arguments[0]&&arguments[0],t={};return e?t.title=window.coscheduleHeadlineStudio.classicEditorApp.currentHeadline:t=void 0!==(0,i.select)("core/editor").getPostEdits().title?(0,i.select)("core/editor").getPostEdits():(0,i.select)("core/editor").getCurrentPost(),t||{}}function v(e){return e?window.coscheduleHeadlineStudio?.classicEditorApp?.getLastAnalyzedHeadline():b("meta").cos_last_analyzed_headline}function T(e){!function(e){const t=document.getElementById("headlinestudio-gutenberg-sidebar-iframe");if(t)try{!function(e,t){JSON.stringify(t,null,0),e.postMessage(t,a)}(t.contentWindow,e)}catch(e){console.error(e)}else console.log("handleTitleChange: hsIframe not found")}({type:"UPDATE_STATE",state:{headline:{text:e}}})}function A(e,t){var n;e?.state?.errors?.[0]?.extensions?.code,t&&(window.coscheduleHeadlineStudio.classicEditorApp.updateAlertBanner(e),window.coscheduleHeadlineStudio.classicEditorApp.updateMetaBoxValuesError(null!==(n=e?.state?.errors?.[0]?.extensions?.code)&&void 0!==n?n:"UNKNOWN",e))}async function N(e,t){try{const{state:{fromApp:n,context:i},state:{headline:{text:o,headlineGroupId:a,headlineId:s,score:l,seoScore:d,isInitialAnalyze:r}={}}={}}=e||{},c=await v(t);if(n&&"competitionAnalysis"===i)return f({[p]:l,[g]:o,[m]:d,[_]:{[w]:l,[E]:o,last_seo_score:d},[S]:!0},{isClassicEditor:t}),void(t&&window.coscheduleHeadlineStudio?.classicEditorApp&&window.coscheduleHeadlineStudio.classicEditorApp.updatePublishMetaBoxValues(l,d));n&&l&&o&&f({[p]:l,[g]:o,[_]:{...c,[w]:l,[E]:o},[S]:!0},{isClassicEditor:t})}catch(e){console.error(e)}}async function z(e,t){const{action:n,isMounted:o}=e.state;if("mountStatus"===n){const{title:n}=H(t),{text:a}=e.state.headline;if(t||(0,i.dispatch)(u).setHeadlineStudioHasMounted(),o&&n!==a){T(n);const e=await v(t);f({[p]:0,[m]:0,[g]:"",[_]:e},{isClassicEditor:t})}}}function M(e){return e?e>=70?"good":e>=40?"warning":e<=39?"issue":"neutral":"neutral"}(0,i.registerStore)(u,h);const{createElement:P}=wp.element,O=(0,i.withSelect)((e=>{const{cos_headline_score:t}=b("meta"),n=e(u)?.getHeadlineStudioHasMounted();return{score:n?t:null}}))((e=>{let{score:t}=e;return P("div",{className:`button-score-container ${M(t)}`},P("svg",{width:20,height:20},P("path",{d:"M17.081,0.44L17.081,0.4L11.971,6.442L11.971,3.233C9.933,3.233 8.041,4.339 8.041,6.875L8.041,11.073L6.812,12.529L6.812,5.53C4.777,5.53 2.891,6.639 2.891,9.172L2.891,19.6C4.929,19.6 6.821,18.494 6.821,15.958L6.821,14.957L8.046,13.51L8.046,17.3C10.081,17.3 11.974,16.194 11.974,13.658L11.974,8.861L13.182,7.436L13.182,14.909C15.217,14.909 17.109,13.8 17.109,11.267L17.109,0.4L17.081,0.44Z"})),P("span",{text:t},t))})),L=window.wp.editPost,I=window.wp.components,U=window.wp.i18n,C=function(e){let{onAnalyzeClick:n}=e;const[i,a]=(0,t.useState)(0),[s,l]=(0,t.useState)(!1);return(0,t.useEffect)((()=>{let e,t=!0;const n={method:"POST",headers:{"content-type":"application/json",Authorization:`Basic ${o()}`},body:JSON.stringify((i=window?.coscheduleHeadlineStudio?.hs_user_id,{query:"query getUser($id: Int!) {\n    getUser(id: $id) {\n      id\n      name\n      email\n      accountSubscription {\n        currentUsage {\n            premiumHeadlinesRemaining\n        }\n      }\n    }\n  }\n  ",variables:{id:Number(i)}}))};var i;return fetch("https://headlines-api.coschedule.com/graphql",n).then((n=>{t&&n.json().then((t=>{var n;e=null!==(n=t?.data?.getUser?.accountSubscription?.currentUsage?.premiumHeadlinesRemaining)&&void 0!==n?n:0,a(e)})).catch((e=>{console.error(e),l(!0)}))})),()=>{t=!1}}),[]),(0,t.createElement)(t.Fragment,null,(0,t.createElement)("div",{className:"headline-studio-analyze-button-panel"},s&&(0,t.createElement)("div",{className:"analyze-button-panel-error"},"There was an error analyzing this headline, please try to analyze it again in a moment."),(0,t.createElement)("button",{type:"button",className:"headline-studio-analyze-button","data-tooltip":`${0===i?"No":i} Premium Headline${1===i?"":"s"} Remaining`,onClick:n},i>0&&(0,t.createElement)("svg",{version:"1.1",xmlns:"http://www.w3.org/2000/svg",width:"12",height:"12",viewBox:"0 0 1024 1024"},(0,t.createElement)("path",{fill:"#FFFFFF",d:"M913.92 0c-232.96 0-465.92 0-698.88 0-33.28 0-66.56 0-99.84 0-12.8 0-20.48 5.12-28.16 10.24 0 0 0 0-2.56 2.56 0 0 0 0 0 0-5.12 7.68-10.24 15.36-10.24 28.16 0 273.92 0 550.4 0 824.32 0 38.4 0 79.36 0 117.76 0 30.72 33.28 48.64 61.44 35.84 125.44-71.68 253.44-143.36 378.88-215.040 125.44 71.68 253.44 143.36 378.88 215.040 25.6 15.36 61.44-5.12 61.44-35.84 0-273.92 0-550.4 0-824.32 0-38.4 0-79.36 0-117.76 0-23.040-17.92-40.96-40.96-40.96zM770.56 345.6c-35.84 35.84-71.68 74.24-107.52 110.080 7.68 51.2 15.36 99.84 23.040 151.040 2.56 17.92-12.8 33.28-30.72 23.040-46.080-23.040-92.16-46.080-138.24-69.12-46.080 23.040-92.16 46.080-138.24 69.12-17.92 7.68-33.28-5.12-30.72-23.040 7.68-51.2 15.36-99.84 23.040-151.040-35.84-35.84-71.68-74.24-107.52-110.080-10.24-10.24-7.68-33.28 10.24-35.84 51.2-7.68 102.4-17.92 153.6-25.6 23.040-46.080 48.64-92.16 71.68-138.24 5.12-7.68 10.24-10.24 17.92-10.24s12.8 2.56 17.92 10.24c23.040 46.080 48.64 92.16 71.68 138.24 51.2 7.68 102.4 17.92 153.6 25.6 15.36 2.56 20.48 25.6 10.24 35.84z"})),"Analyze Headline"),(0,t.createElement)("div",{className:"headline-studio-analyze-help-link"},(0,t.createElement)(I.Button,{href:"https://coschedule.com/support",variant:"link",target:"_blank",rel:"noopener"},"Get Help"))))},x=function(e){let{isAnalyzed:n}=e;const i=o(),s=H(),{id:l,type:d,title:r,guid:c}=s||{},u=function(e){const{embedToken:t,postType:n,postId:i,postTitle:o,postUrl:s,analyze:l}=e||{},d=new URL(`${a}/headlines/import`),{searchParams:r}=d;return r.append("platform","wordpress"),r.append("source","WordPress"),t&&r.append("embedToken",t),o&&r.append("headline",o),n&&r.append("embedSourceType",n),i&&r.append("embedSourceId",i),l&&r.append("analyze","true"),d.toString()}({embedToken:i,postType:d,postId:l,postTitle:r,postUrl:c,analyze:!n});return(0,t.createElement)(t.Fragment,null,(0,t.createElement)("iframe",{id:"headlinestudio-gutenberg-sidebar-iframe",className:"headlinestudio-gutenberg-sidebar-iframe",src:u}))};let F,k=!1,R=!1;const D=function(){if(!o())return function(){const e=`${window.coscheduleHeadlineStudio.hs_admin_url_base}/options-general.php?page=headline-studio-settings`;return(0,t.createElement)(t.Fragment,null,(0,t.createElement)("div",{className:"headlinestudio-gutenberg-sidebar-not-connected"},(0,t.createElement)("h5",null,"No account connected"),(0,t.createElement)("p",null,"Run the Headline Studio Setup Wizard to complete your connection."),(0,t.createElement)("a",{href:e,className:"hs-wp-go-to-settings hs-wp-button blue"},"Go To Settings")))}();const[e,n]=(0,t.useState)(!1),[a,l]=(0,t.useState)(!0),{id:d,type:r,title:c,guid:u}=H();return(0,t.useEffect)((()=>{const e=function(){const{cos_headline_has_been_analyzed:e}=(0,i.select)("core/editor").getCurrentPostAttribute("meta");return e}();n(e),l(!e)}),[]),a?(0,t.createElement)(t.Fragment,null," ",(0,t.createElement)(C,{onAnalyzeClick:()=>{f({[S]:!0}),(0,i.dispatch)("core/editor").savePost().then((()=>l(!1)))}})," "):(k||(function(){let e=arguments.length>0&&void 0!==arguments[0]&&arguments[0];s((t=>{const{data:n,origin:i}=t,{type:o}=n;if((i.includes("coschedule.com")||i===window.origin)&&("UPDATE_ERROR"===o&&A(n,e),"UPDATE_STATE"===o&&N(n,e),"EMBED_STATE"===o&&z(n,e),"COS_SAVE_POST_META"===o)){const e=H(),{meta:t}=e;t&&y(t)}}))}(),F=c,k=!0,(0,i.subscribe)((()=>{const e=b("title"),{last_headline_text:t,last_headline_score:n,last_seo_score:i}=v();F!==e?(F=e,R=!0,T(F),f({[g]:"",[p]:0,[m]:0,[_]:{last_headline_text:t,last_headline_score:n,last_seo_score:i}})):t===F&&R&&(R=!1,f({[g]:t,[p]:n,[m]:i}))}))),(0,t.createElement)(t.Fragment,null,(0,t.createElement)("div",{className:"headlinestudio-gutenberg-sidebar-iframe-container"},(0,t.createElement)(x,{isAnalyzed:e}))))},$=(0,i.withSelect)((()=>{}))((()=>(0,t.createElement)(t.Fragment,null,(0,t.createElement)(L.PluginSidebarMoreMenuItem,{target:"hs-doc-sidebar"},(0,U.__)("Headline Studio","hs")),(0,t.createElement)(L.PluginSidebar,{name:"hs-doc-sidebar",title:(0,U.__)("Headline Studio","hs")},(0,t.createElement)(I.PanelBody,{intialOpen:!0},(0,t.createElement)(D,null))))));(0,n.registerPlugin)("hs-sidebar",{icon:(0,t.createElement)(O,null),render:$})})();