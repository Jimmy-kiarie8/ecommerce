// =================================================================== 
// Project Name:           jay
// Date/Time Generated:    05/16/2017 17:57
// 
// =================================================================== 
// Server List:
// 
// Local Deployment
// =================================================================== 

function Main() 
{
 var app = Application;

 var DeploymentManager = Application.DeploymentManager;

   // =================================================================== 
   // Logging Options
   // =================================================================== 
   DeploymentManager.SetLogging(true);
   DeploymentManager.SetLogFileName("C:\\Program Files (x86)\\Macromedia\\HomeSite 5\\Deployment.log");
   // =================================================================== 
   // End Logging Options
   // =================================================================== 
   DeploymentManager.OpenProject("C:\\Users\\williamPC\\Desktop\\javascript\\jay.apf");
   // =================================================================== 
   // Bypass servers and perform local deployment
   // =================================================================== 
   DeploymentManager.IsLocalDeployment = true;
   // =================================================================== 
   // Set Deployment Flags...
   // =================================================================== 
   DeploymentManager.CreateFolder = true;
   DeploymentManager.UploadOnlyIfNewer = true;
   DeploymentManager.EncryptCFML = false;
   DeploymentManager.ForceLowerCase = false;
   // =================================================================== 
   // Server  Deployment
   // =================================================================== 
      DeploymentManager.CheckServerFolders("");
   // >>> Folder: jay\javascript
   // File:C:\Users\williamPC\Desktop\javascript\onclick.html
   DeploymentManager.UploadFile("C:\\Users\\williamPC\\Desktop\\javascript\\onclick.html","onclick.html");
   // File:C:\Users\williamPC\Desktop\javascript\onclick.txt
   DeploymentManager.UploadFile("C:\\Users\\williamPC\\Desktop\\javascript\\onclick.txt","onclick.txt");
   DeploymentManager.CloseProject();
 
}
