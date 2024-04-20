## CI/CD deployment with webhooks
CI/CD pipeline is implemented through github webhooks.

## How to deploy my updates
1. Use the `staging` branch to test your updates
2. Create a pull request; master/main branch as the BASE and staging as the HEAD
3. Name or title your PR to `deploy to server` (case-sensitive) as it will trigger the update in the server.
4. Once approved, check your email for confirmation (with subject: CI/CD Webhooks Notification)
5. Always check the email message every after successful PR to confirm the status of the deployment.

> Note: `deploy to server` is the final command to trigger the update/deployment process. 

### How it works
- The server will check for any direct updates in the cpanel file manager.
- If none, pull updates from the main.
- Otherwise, checkout to the `cpanel-untracked` branch and reapply the changes. 
- After a successful commit and pushing to remote, checkout back to the master/main branch.