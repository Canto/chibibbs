<?php
if(!defined("__CHIBI__")) exit();
?>
<div class="span12 text-center">
<p class="text-center"><a href="javascript:history.go(-1);"><span class="label label-info">돌아가기</span></a></p>
</div>
<div class="container text-center">
<?php echo $set_tool;?>
</div>
<div class="container">
<div class="span12 alert alert-info marginTop20">
<div class="span12">
- 단축키 안내
</div>
<?php if($tool=="chibi"){?>
<div class="span5">
M : 선택 <br/>
V : 이동 <br/>
G : 페인트버킷 <br/>
R : 캔버스 회전 <br/>
[,] : 툴사이즈조절 <br/>
Ctrl+Z : undo <br/>
Ctrl+Shift+Z : redo <br/>
마우스오른쪽 클릭 : 색상 피커<br/>
</div>
<div class="span5 offset1">
P : 연필 <br/>
B : 브러쉬 <br/>
A : 에어 브러쉬 <br/>
W : 수채화 툴 <br/>
E : 지우개 <br/>
S : 부드러운 지우개 <br/>
O : 혼합 <br/>
C : 색 혼합 <br/>
D : 닷지 <br/>
</div>
<?php }else{ ?>
<div class="span5">
1,2,3,4 : 톤변경 <br/>
[,] : 툴사이즈조절 <br/>
Ctrl+Z : undo <br/>
Ctrl+Y : redo <br/>
L : 게시판의 그림로드 <br/>
T : 반투명브러쉬 <br/>
TT : 브러쉬옵션 <br/>
G : 4단톤브러쉬 <br/>
B : 페인트버킷 <br/>
E : 지우개 <br/>
N : 펜<br/>
Shift+Click : 중간색선택<br/>
Ctrl+Click : 일반피커<br/>
</div>
<div class="span5 offset1">
S : 복구정보 강제저장<br/>
C : 영역지정 변환명령<br/>
복사,마스크적용복사<br/>
수직플립,수평플립<br/>
색반전,모자이크,<br/>
평균값모자이크,Q0마스크<br/>
F : 플로트/드롭 <br/>
R : 플로터제거<br/>
P : 1번팔렛교체 <br/>
X : 글쓰기툴<br/>
O : 옵션창<br/>
</div>
<? } ?>
</div>
</div>
