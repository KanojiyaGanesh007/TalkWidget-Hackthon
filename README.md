# Talk Widget

A template to get started with Nextcloud app development.

## Usage

- To get started easily use the [Appstore App generator](https://apps.nextcloud.com/developer/apps/generate) to
  dynamically generate an App based on this repository with all the constants prefilled.
- Alternatively you can use the "Use this template" button on the top of this page to create a new repository based on
  this repository. Afterwards adjust all the necessary constants like App ID, namespace, descriptions etc.

Once your app is ready follow the [instructions](https://nextcloudappstore.readthedocs.io/en/latest/developer.html) to
upload it to the Appstore.

## Resources

### Documentation for developers:

- General documentation and tutorials: https://nextcloud.com/developer
- Technical documentation: https://docs.nextcloud.com/server/latest/developer_manual
- Nextcloud Talk Dashboard Widget –
Integrated Chat Expe
]
Date: September 2025
Prepared by: [Binary Brains]
1.	Overview
Nextcloud is a leading open-source platform for file sharing and collaboration, widely recognized for prioritizing user privacy. Talk, one of its flagship tools, enables secure messaging and conferencing.
This project introduces a Dashboard widget that embeds a Talk room’s conversation feed directly into the Dashboard. By doing so, users can check, respond to, and manage chats without moving away from their main workspace.
Why this Matters:
1.	Reduces the need to switch between applications.
2.	Strengthens team communication by making updates instantly visible.
3.	Aligns with modern collaboration trends for consolidated tools.
2.	Identified Challenges
Users often face productivity gaps when forced to navigate away from the Dashboard to access Talk:
-	A supervisor monitoring progress must interrupt their workflow to reply in Talk.
-	Time-sensitive notifications can be overlooked without dashboard-level visibility.
-	Highlighting crucial information like mentions or keywords is inconvenient.
Proposed Fix: An embedded chat widget that offers real-time updates and direct interactions on the main Dashboard.
3.	Aims and Deliverables
1.	Show messages from a chosen Talk room inside the Dashboard.
2.	Provide a text box for sending responses without opening Talk separately.
3.	Maintain timely updates through polling or server-sent events.
-	Introduce keyword or mention filters.
-	Offer previews for media or shared links.
Success Indicator: Reduce interface-switching time by at least 25% for active users.
4.	Technology Stack & Design
Languages & Frameworks:
-	JavaScript and Vue.js  for a modular, reactive UI.
-	PHP for seamless server-side operations within Nextcloud.
-	CSS for styling and responsive layout.
APIs in Use:
-	Nextcloud Dashboard Widget API for integration.
-	Nextcloud Talk API for fetching and posting chat data.
Real-time Strategy: Polling at regular intervals for MVP, with scalability toward WebSockets or SSE.
Workflow:
PHP connects with the Talk API, retrieves messages, and serves them to the Vue.js frontend. Users’ replies travel back through PHP to update the Talk room feed.
5.	Main Features
MVP:
-	Embedded chat feed for one Talk room.
-	Inline reply functionality.
-	Automatic refresh using polling.
Advanced (Time Permitting):
-	Highlight messages containing specific terms.
-	Emoji or reaction buttons.
-	Inline previews for links and images.
Example Use Case:  A developer can check a message, send a quick reply, and continue tracking tasks—all without leaving the Dashboard.

6.File Structure
nextclou/server/
apps/talkwidget/
├── appinfo/
│   ├── info.xml
│   └── routes.php
├── css/
│   └── dashboard.css
├── img/
│   ├── app-dark.svg
│   └── app.svg
├── js/
│   ├── talkwidget-dashboardTalk.mjs
│   └── talkwidget-dashboardTalk.mjs.map
├── lib/
│   ├── AppInfo/
│   │   └── Application.php
│   ├── Controller/
│   │   ├── ApiController.php
│   │   └── PageController.php
│   ├── Dashboard/
│   │   └── TalkWidget.php
│   └── Service/
│       └── TalkService.php
├── node_modules/        # (frontend deps, optional in repo)
├── src/                 # (probably your JS/TS source before bundling)
├── templates/
│   └── index.php
├── .github/             # (actions/ci configs)
├── CHANGELOG.md
├── CODE_OF_CONDUCT.md
├── LICENSE
├── README.md
├── composer.json
├── package.json
├── package-lock.json 
├── vite.config.js
├── stylelint.config.cjs
├── rector.php
├── psalm.xml
├── openapi.json
└── ... (other dev configs)



7.Widget Setup
Prepare the app skeleton 
  •	Go to the app skeleton generator and generate an app or take the this file put it in the nextcloud/server/apps.
Implement and register the dashboard widget
    •	implement the dashboard widget.
Front-end
  •	nvm use –lts
  •	npm install
  • npm i --save @nextcloud/axios @nextcloud/dialogs @nextcloud/initial-state @nextcloud/l10n @nextcloud/router vue-material-design-icons
  •	npm i --save-dev vite-plugin-eslint vite-plugin-stylelint
Network requests
  •	npm run dev
Enable and test the app
  • Go to the your apps and enable it and back to dashboard to see the widget.

7.Testing Approach
-	Unit Tests: Check PHP functions and Vue components independently.
-	Integration Tests: Ensure smooth data flow between backend and frontend.
-	Load/Performance Tests: Validate performance under frequent updates.
-	User Testing: Gather real-world feedback from team members or hackathon judges.
-	Fallback Verification: Confirm polling works if advanced real-time methods fail.
8.Future Enhancements
Short-term:
-	Add room selection tabs and notification badges.
Medium-term:
-	Provide AI-driven message highlights and summaries.
Long-term:
-	Replace polling entirely with SSE/WebSocket for scalable real-time support.
-	Link with Nextcloud Calendar and Tasks for unified workflows.
9. Competitive Edge
-	First chat widget tailored for Nextcloud Dashboard.
-	Saves significant time by removing unnecessary navigation.
-	Uses widely adopted technologies (Vue, PHP, JavaScript, CSS) for easy maintenance.
10.Reference Material
-	Nextcloud Widget API Docs: https://docs.nextcloud.com/server/latest/developer_manual/client_apis/dashboard/widgets.html
-	Nextcloud Talk API Docs: https://nextcloud-talk.readthedocs.io/
-	Vue.js Guide: https://vuejs.org/
-	PHP Manual: https://www.php.net/manual/en/
-	CSS Resource: https://developer.mozilla.org/en-US/docs/Web/CSS


### Help for developers:

- Official community chat: https://cloud.nextcloud.com/call/xs25tz5y
- Official community forum: https://help.nextcloud.com/c/dev/11
